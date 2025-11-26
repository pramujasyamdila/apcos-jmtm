<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Md_daftar_km extends CI_Model
{
    private $db_kms;
    private $romanMap = null;

    public function __construct()
    {
        parent::__construct();
        $this->db_kms = $this->load->database('db_kms', TRUE);
        // pastikan cache driver sudah di-load di autoload atau controller: $this->load->driver('cache', ['adapter' => 'file']);
    }

    // helper to produce uid (same as earlier)
    private function make_uid($cat, $nomor)
    {
        $n = str_replace('.', '_', (string)$nomor);
        return $cat . '__' . $n;
    }

    // simple roman map
    private function roman($num)
    {
        if ($this->romanMap === null) {
            $this->romanMap = [
                0 => "",
                1 => "I",
                2 => "II",
                3 => "III",
                4 => "IV",
                5 => "V",
                6 => "VI",
                7 => "VII",
                8 => "VIII",
                9 => "IX",
                10 => "X",
                11 => "XI",
                12 => "XII",
                13 => "XIII",
                14 => "XIV",
                15 => "XV",
                16 => "XVI",
                17 => "XVII",
                18 => "XVIII",
                19 => "XIX",
                20 => "XX",
                21 => "XXI",
                22 => "XXII",
                23 => "XXIII",
                24 => "XXIV",
                25 => "XXV"
            ];
        }
        return $this->romanMap[intval($num)] ?? "";
    }

    // ========================
    // SORTING NOMOR BERTINGKAT
    // ========================
    private function sort_nomor($a, $b)
    {
        $pa = explode('.', $a['nomor']);
        $pb = explode('.', $b['nomor']);

        $len = max(count($pa), count($pb));

        for ($i = 0; $i < $len; $i++) {
            $va = isset($pa[$i]) ? intval($pa[$i]) : 0;
            $vb = isset($pb[$i]) ? intval($pb[$i]) : 0;

            if ($va < $vb) return -1;
            if ($va > $vb) return 1;
        }
        return 0;
    }


    /**
     * generate_tree_fast
     * - single entry point to build flattened tree for all categories
     * - $add_ke: 0 => kontrak awal; 1..N => Adendum ke-n
     */
    public function generate_tree_fast($id_kontrak, $add_ke = 1)
    {
        $cache_key = "tree_{$id_kontrak}_{$add_ke}";
        // try cache (ensure cache driver enabled)
        if ($this->cache && $cached = $this->cache->get($cache_key)) {
            return $cached;
        }

        $tree = [];

        // fetch kontrak basic from mst_kontrak in db_kms
        $kontrak = $this->db_kms->where('id_kontrak', $id_kontrak)->get('mst_kontrak')->row();
        if (!$kontrak) {
            // empty
            $this->cache->save($cache_key, $tree, 60);
            return $tree;
        }

        // determine root add value (nilai_kontrak_awal or nilai_add_*)
        if (empty($add_ke) || $add_ke === "0") {
            $root_add_val = $kontrak->nilai_kontrak_awal ?? 0;
        } else {
            $roman = $this->roman(intval($add_ke));
            $field_add = "nilai_add_" . $roman;
            $root_add_val = isset($kontrak->$field_add) ? $kontrak->$field_add : 0;
        }

        // push ROOT
        $root = [
            "unique_id" => "ROOT",
            "parent_uid" => "",
            "kategori" => "ROOT",
            "nomor" => "1",
            "nama_program" => $kontrak->nama_kontrak,
            "awal" => (float)($kontrak->nilai_kontrak_awal ?? 0),
            "add_val" => (float)$root_add_val,
            "add1" => (float)$root_add_val, // compatibility
            "level" => 0,
            "id_kontrak" => $kontrak->id_kontrak
        ];
        $tree[] = $root;

        // category mappings (table names + base fields) — menggunakan pola yg kamu sebutkan
        $categories = [
            'CAPEX' => $this->build_category_map('capex', $add_ke),
            'OPEX'  => $this->build_category_map('opex', $add_ke),
            'BUA'   => $this->build_category_map('bua', $add_ke),
            'SDM'   => $this->build_category_map('sdm', $add_ke)
        ];

        // untuk setiap category kita fetch base rows, lalu ambil children level-by-level
        foreach ($categories as $catKey => $map) {
            // if base table doesn't exist, skip
            if (!$this->db_kms->table_exists($map['base_table'])) continue;

            // 1) ambil semua baris base untuk id_kontrak (satu query)
            $baseRows = $this->db_kms->where($map['base_parent_field'], $id_kontrak)
                ->order_by($map['base_no_field'], 'ASC')
                ->get($map['base_table'])->result();

            if (!$baseRows) continue;

            // siapkan container id -> rows per level
            $levels_data = [];
            // level 0 = base
            $levels_data[0] = $baseRows;

            // iterative fetch detail levels: untuk setiap level, ambil rows dimana parent IN previous_ids
            $prev_ids = array_map(function ($r) use ($map) {
                // base id field
                return isset($r->{$map['base_id']}) ? $r->{$map['base_id']} : null;
            }, $baseRows);
            $prev_ids = array_filter($prev_ids);

            // level loop hingga 8 (1..8)
            for ($lvl = 1; $lvl <= 8; $lvl++) {
                if (!isset($map['levels'][$lvl])) break;
                $lvlMap = $map['levels'][$lvl];
                if (!$this->db_kms->table_exists($lvlMap['table'])) break;
                if (empty($prev_ids)) {
                    // tidak ada parent, stop
                    break;
                }
                // ambil rows dengan parent IN prev_ids
                $rows = $this->db_kms->where_in($lvlMap['parent'], $prev_ids)
                    ->order_by($lvlMap['no'], 'ASC')
                    ->get($lvlMap['table'])->result();
                if (!$rows) {
                    // kosong -> hentikan loop selanjutnya (no children)
                    $prev_ids = [];
                    break;
                }
                $levels_data[$lvl] = $rows;
                // set prev_ids untuk next loop
                $prev_ids = array_map(function ($r) use ($lvlMap) {
                    return isset($r->{$lvlMap['id']}) ? $r->{$lvlMap['id']} : null;
                }, $rows);
                $prev_ids = array_filter($prev_ids);
            }

            // build lookup maps: per level, keyed by parent id for fast assembly
            $lookup = []; // lookup[level][parent_id] => array(rows)
            // populate for level 1..n (detail levels)
            foreach ($levels_data as $levelIndex => $rowsArr) {
                if ($levelIndex === 0) {
                    // base level keyed by contract id (parent is id_kontrak)
                    foreach ($rowsArr as $r) {
                        $parent = $map['base_parent_field'] . '::' . $id_kontrak; // virtual parent key
                        if (!isset($lookup[0])) $lookup[0] = [];
                        $lookup[0][$id_kontrak][] = $r;
                    }
                } else {
                    $lvlMap = $map['levels'][$levelIndex];
                    foreach ($rowsArr as $r) {
                        $p = isset($r->{$lvlMap['parent']}) ? $r->{$lvlMap['parent']} : null;
                        if ($p === null) continue;
                        if (!isset($lookup[$levelIndex])) $lookup[$levelIndex] = [];
                        if (!isset($lookup[$levelIndex][$p])) $lookup[$levelIndex][$p] = [];
                        $lookup[$levelIndex][$p][] = $r;
                    }
                }
            }

            // now flatten: we will traverse base rows and recursively traverse children using lookup
            $base_id_field = $map['base_id'];
            $base_no_field = $map['base_no_field'];
            $base_name_field = $map['base_name_field'];
            $base_awal_field = $map['base_awal'];
            $base_add_field  = $map['base_add'];

            // helper recursive closure
            $that = $this;
            $make_uid = function ($cat, $nomor) use ($that) {
                $n = str_replace('.', '_', (string)$nomor);
                return $cat . '__' . $n;
            };

            $process_node = function ($row, $kategori, $nomor, $name, $awal_val, $add_val, $level, $id_field, $id_value) use (&$process_node, &$tree, $lookup, $map, $make_uid) {
                // push current node
                $uid = $make_uid($kategori, $nomor);
                $parent_uid = ($level === 0) ? "ROOT" : null; // will be set by caller traversal when processing children

                $entry = [
                    "unique_id" => $uid,
                    "parent_uid" => "", // caller will fill correct parent_uid by context
                    "kategori" => $kategori,
                    "nomor" => $nomor,
                    "nama_program" => $name,
                    "awal" => (float)$awal_val,
                    "add_val" => (float)$add_val,
                    "add1" => (float)$add_val,
                    "level" => $level,
                    "id_kontrak" => isset($row->id_kontrak) ? $row->id_kontrak : null,
                ];
                // include original id for convenience
                if ($id_field && $id_value) {
                    $entry[$id_field] = $id_value;
                }
                $tree[] = $entry;
                // NOTE: parent_uid will be adjusted by caller (we append flat and later can patch parent_uid if desired)
            };

            // We'll do a deterministic traversal: base rows in order, then depth-first children.
            // But to keep parent relation, we will manually push nodes while tracking parent UIDs.
            $push_node = function ($row, $kategori, $nomor, $name, $awal_val, $add_val, $level, $id_field, $id_value, $parentUID)
            use (&$tree, $make_uid) {

                $uid = $make_uid($kategori, $nomor);

                $entry = [
                    "unique_id" => $uid,
                    "parent_uid" => $parentUID,
                    "kategori" => $kategori,
                    "nomor" => $nomor,
                    "nama_program" => $name,
                    "awal" => (float)$awal_val,
                    "add_val" => (float)$add_val,
                    "level" => $level,
                    "id_kontrak" => isset($row->id_kontrak) ? $row->id_kontrak : null,
                ];

                // simpan original ID (misal id_capex_detail, id_opex, dst)
                if ($id_field && $id_value) {
                    $entry[$id_field] = $id_value;
                }

                // =========================================
                // 🔥 LOOP TAMBAHKAN ADDENDUM add1..add25
                // =========================================
                for ($i = 1; $i <= 25; $i++) {

                    // bentuk key berdasarkan pola DB kamu:
                    // nilai_capex_add_I / nilai_detail_capex_add_IV / dst.
                    $roman = $this->roman($i);
                    $baseName = strtolower($kategori);

                    // GENERATE kemungkinan nama field
                    $possibleFields = [
                        "nilai_{$baseName}_add_{$roman}",
                        "nilai_{$baseName}_detail_{$roman}",
                        "nilai_{$baseName}_detail_1_add_{$roman}",
                        "nilai_detail_{$baseName}_add_{$roman}",
                        "add_" . $roman,   // fallback universal
                    ];

                    foreach ($possibleFields as $f) {
                        if (property_exists($row, $f) && floatval($row->$f) > 0) {
                            $entry["add{$i}"] = floatval($row->$f);
                            break;
                        }
                    }
                }

                $tree[] = $entry;
            };


            // start: traverse each base row
            foreach ($baseRows as $b) {
                $nomor = isset($b->{$base_no_field}) ? $b->{$base_no_field} : $b->{$base_id_field};
                $name = isset($b->{$base_name_field}) ? $b->{$base_name_field} : '';
                $awal_val = isset($b->{$base_awal_field}) ? $b->{$base_awal_field} : 0;
                $add_val = isset($b->{$base_add_field}) ? $b->{$base_add_field} : 0;
                $parentUID = "ROOT";

                // push base node
                $push_node($b, $catKey, $nomor, $name, $awal_val, $add_val, 0, $base_id_field, isset($b->{$base_id_field}) ? $b->{$base_id_field} : null, $parentUID);

                // recursively traverse children levels with stack (iterative DFS)
                $stack = [];
                // seed with level 1 children of this base (if any)
                if (isset($map['levels'][1])) {
                    $lvl1 = $map['levels'][1];
                    $children = $lookup[1][isset($b->{$base_id_field}) ? $b->{$base_id_field} : 0] ?? [];
                    foreach ($children as $c) {
                        $stack[] = ['row' => $c, 'lvl' => 1, 'parentUID' => $catKey . '__' . str_replace('.', '_', $nomor)];
                    }
                }
                while (!empty($stack)) {
                    $node = array_pop($stack);
                    $r = $node['row'];
                    $lvl = $node['lvl'];
                    $parentUID = $node['parentUID'];

                    $lvlMap = $map['levels'][$lvl];
                    $nom = isset($r->{$lvlMap['no']}) ? $r->{$lvlMap['no']} : (isset($r->{$lvlMap['id']}) ? $r->{$lvlMap['id']} : '');
                    $nm  = isset($r->{$lvlMap['nama']}) ? $r->{$lvlMap['nama']} : '';
                    $awal_v = isset($r->{$lvlMap['awal']}) ? $r->{$lvlMap['awal']} : 0;
                    $add_v  = isset($r->{$lvlMap['add']}) ? $r->{$lvlMap['add']} : 0;
                    $id_val = isset($r->{$lvlMap['id']}) ? $r->{$lvlMap['id']} : null;

                    $push_node($r, $catKey, $nom, $nm, $awal_v, $add_v, $lvl, $lvlMap['id'], $id_val, $parentUID);

                    // push children of current node (next level)
                    $nextLvl = $lvl + 1;
                    if (isset($map['levels'][$nextLvl]) && isset($lookup[$nextLvl])) {
                        $childRows = $lookup[$nextLvl][$id_val] ?? [];
                        foreach ($childRows as $ch) {
                            $stack[] = ['row' => $ch, 'lvl' => $nextLvl, 'parentUID' => $catKey . '__' . str_replace('.', '_', $nom)];
                        }
                    }
                } // end while stack
            } // end foreach baseRows
        } // end foreach categories
        if ($this->cache) {
            $this->cache->save($cache_key, $tree, 30);
        }

        // === FINAL SORTING NOMOR ===
        usort($tree, function ($a, $b) {
            return $this->sort_nomor($a, $b);
        });

        return $tree;
    }
    private function build_category_map($category, $add_ke)
    {
        $roman = $this->roman(intval($add_ke)) ?: "I";

        switch ($category) {

                // ============================
                //          CAPEX
                // ============================
            case 'capex':
                return [
                    'base_table' => 'tbl_capex',
                    'base_parent_field' => 'id_kontrak',
                    'base_no_field' => 'no_urut',
                    'base_name_field' => 'nama_uraian',
                    'base_awal' => 'nilai_capex',
                    'base_add' => "nilai_capex_add_" . $roman,
                    'base_id' => 'id_capex',

                    'levels' => [

                        1 => [
                            'table' => 'tbl_capex_detail',
                            'parent' => 'id_capex',
                            'no' => 'no_urut',
                            'nama' => 'nama_uraian',
                            'awal' => 'nilai_detail_capex',
                            'add' => "nilai_detail_capex_add_" . $roman,
                            'id' => 'id_capex_detail'
                        ],

                        2 => [
                            'table' => 'tbl_detail_capex_1',
                            'parent' => 'id_capex_detail',
                            'no' => 'no_urut_1_capex',
                            'nama' => 'nama_uraian_1_capex',
                            'awal' => 'nilai_capex_detail_1',
                            'add' => "nilai_capex_detail_1_add_" . $roman,
                            'id' => 'id_detail_capex_1'
                        ],

                        3 => [
                            'table' => 'tbl_detail_capex_2',
                            'parent' => 'id_detail_capex_1',
                            'no' => 'no_urut_2_capex',
                            'nama' => 'nama_uraian_2_capex',
                            'awal' => 'nilai_capex_detail_2',
                            'add' => "nilai_capex_detail_2_add_" . $roman,
                            'id' => 'id_detail_capex_2'
                        ],

                        4 => [
                            'table' => 'tbl_detail_capex_3',
                            'parent' => 'id_detail_capex_2',
                            'no' => 'no_urut_3_capex',
                            'nama' => 'nama_uraian_3_capex',
                            'awal' => 'nilai_capex_detail_3',
                            'add' => "nilai_capex_detail_3_add_" . $roman,
                            'id' => 'id_detail_capex_3'
                        ],

                        5 => [
                            'table' => 'tbl_detail_capex_4',
                            'parent' => 'id_detail_capex_3',
                            'no' => 'no_urut_4_capex',
                            'nama' => 'nama_uraian_4_capex',
                            'awal' => 'nilai_capex_detail_4',
                            'add' => "nilai_capex_detail_4_add_" . $roman,
                            'id' => 'id_detail_capex_4'
                        ],

                        6 => [
                            'table' => 'tbl_detail_capex_5',
                            'parent' => 'id_detail_capex_4',
                            'no' => 'no_urut_5_capex',
                            'nama' => 'nama_uraian_5_capex',
                            'awal' => 'nilai_capex_detail_5',
                            'add' => "nilai_capex_detail_5_add_" . $roman,
                            'id' => 'id_detail_capex_5'
                        ],

                        7 => [
                            'table' => 'tbl_detail_capex_6',
                            'parent' => 'id_detail_capex_5',
                            'no' => 'no_urut_6_capex',
                            'nama' => 'nama_uraian_6_capex',
                            'awal' => 'nilai_capex_detail_6',
                            'add' => "nilai_capex_detail_6_add_" . $roman,
                            'id' => 'id_detail_capex_6'
                        ],

                        8 => [
                            'table' => 'tbl_detail_capex_7',
                            'parent' => 'id_detail_capex_6',
                            'no' => 'no_urut_7_capex',
                            'nama' => 'nama_uraian_7_capex',
                            'awal' => 'nilai_capex_detail_7',
                            'add' => "nilai_capex_detail_7_add_" . $roman,
                            'id' => 'id_detail_capex_7'
                        ],
                    ]
                ];

                // ============================
                //          OPEX
                // ============================
            case 'opex':
                return [
                    'base_table' => 'tbl_opex',
                    'base_parent_field' => 'id_kontrak',
                    'base_no_field' => 'no_urut',
                    'base_name_field' => 'nama_uraian',
                    'base_awal' => 'nilai_opex',
                    'base_add' => "nilai_opex_add_" . $roman,
                    'base_id' => 'id_opex',

                    'levels' => [

                        1 => [
                            'table' => 'tbl_opex_detail',
                            'parent' => 'id_opex',
                            'no' => 'no_urut',
                            'nama' => 'nama_uraian',
                            'awal' => 'nilai_detail_opex',
                            'add' => "nilai_detail_opex_add_" . $roman,
                            'id' => 'id_opex_detail'
                        ],

                        2 => [
                            'table' => 'tbl_detail_opex_1',
                            'parent' => 'id_opex_detail',
                            'no' => 'no_urut_1_opex',
                            'nama' => 'nama_uraian_1_opex',
                            'awal' => 'nilai_opex_detail_1',
                            'add' => "nilai_opex_detail_1_add_" . $roman,
                            'id' => 'id_detail_opex_1'
                        ],

                        3 => [
                            'table' => 'tbl_detail_opex_2',
                            'parent' => 'id_detail_opex_1',
                            'no' => 'no_urut_2_opex',
                            'nama' => 'nama_uraian_2_opex',
                            'awal' => 'nilai_opex_detail_2',
                            'add' => "nilai_opex_detail_2_add_" . $roman,
                            'id' => 'id_detail_opex_2'
                        ],

                        4 => [
                            'table' => 'tbl_detail_opex_3',
                            'parent' => 'id_detail_opex_2',
                            'no' => 'no_urut_3_opex',
                            'nama' => 'nama_uraian_3_opex',
                            'awal' => 'nilai_opex_detail_3',
                            'add' => "nilai_opex_detail_3_add_" . $roman,
                            'id' => 'id_detail_opex_3'
                        ],

                        5 => [
                            'table' => 'tbl_detail_opex_4',
                            'parent' => 'id_detail_opex_3',
                            'no' => 'no_urut_4_opex',
                            'nama' => 'nama_uraian_4_opex',
                            'awal' => 'nilai_opex_detail_4',
                            'add' => "nilai_opex_detail_4_add_" . $roman,
                            'id' => 'id_detail_opex_4'
                        ],

                        6 => [
                            'table' => 'tbl_detail_opex_5',
                            'parent' => 'id_detail_opex_4',
                            'no' => 'no_urut_5_opex',
                            'nama' => 'nama_uraian_5_opex',
                            'awal' => 'nilai_opex_detail_5',
                            'add' => "nilai_opex_detail_5_add_" . $roman,
                            'id' => 'id_detail_opex_5'
                        ],

                        7 => [
                            'table' => 'tbl_detail_opex_6',
                            'parent' => 'id_detail_opex_5',
                            'no' => 'no_urut_6_opex',
                            'nama' => 'nama_uraian_6_opex',
                            'awal' => 'nilai_opex_detail_6',
                            'add' => "nilai_opex_detail_6_add_" . $roman,
                            'id' => 'id_detail_opex_6'
                        ],

                        8 => [
                            'table' => 'tbl_detail_opex_7',
                            'parent' => 'id_detail_opex_6',
                            'no' => 'no_urut_7_opex',
                            'nama' => 'nama_uraian_7_opex',
                            'awal' => 'nilai_opex_detail_7',
                            'add' => "nilai_opex_detail_7_add_" . $roman,
                            'id' => 'id_detail_opex_7'
                        ],
                    ]
                ];

                // ============================
                //            BUA
                // ============================
            case 'bua':
                return [
                    'base_table' => 'tbl_bua',
                    'base_parent_field' => 'id_kontrak',
                    'base_no_field' => 'no_urut',
                    'base_name_field' => 'nama_uraian',
                    'base_awal' => 'nilai_bua',
                    'base_add' => "nilai_bua_add_" . $roman,
                    'base_id' => 'id_bua',

                    'levels' => [
                        1 => [
                            'table' => 'tbl_bua_detail',
                            'parent' => 'id_bua',
                            'no' => 'no_urut',
                            'nama' => 'nama_uraian',
                            'awal' => 'nilai_detail_bua',
                            'add' => "nilai_detail_bua_add_" . $roman,
                            'id' => 'id_bua_detail'
                        ],
                        2 => [
                            'table' => 'tbl_detail_bua_1',
                            'parent' => 'id_bua_detail',
                            'no' => 'no_urut_1_bua',
                            'nama' => 'nama_uraian_1_bua',
                            'awal' => 'nilai_bua_detail_1',
                            'add' => "nilai_bua_detail_1_add_" . $roman,
                            'id' => 'id_detail_bua_1'
                        ],
                        3 => [
                            'table' => 'tbl_detail_bua_2',
                            'parent' => 'id_detail_bua_1',
                            'no' => 'no_urut_2_bua',
                            'nama' => 'nama_uraian_2_bua',
                            'awal' => 'nilai_bua_detail_2',
                            'add' => "nilai_bua_detail_2_add_" . $roman,
                            'id' => 'id_detail_bua_2'
                        ],
                    ]
                ];

                // ============================
                //            SDM
                // ============================
            case 'sdm':
                return [
                    'base_table' => 'tbl_sdm',
                    'base_parent_field' => 'id_kontrak',
                    'base_no_field' => 'no_urut',
                    'base_name_field' => 'nama_uraian',
                    'base_awal' => 'nilai_sdm',
                    'base_add' => "nilai_sdm_add_" . $roman,
                    'base_id' => 'id_sdm',

                    'levels' => [
                        1 => [
                            'table' => 'tbl_sdm_detail',
                            'parent' => 'id_sdm',
                            'no' => 'no_urut',
                            'nama' => 'nama_uraian',
                            'awal' => 'nilai_detail_sdm',
                            'add' => "nilai_detail_sdm_add_" . $roman,
                            'id' => 'id_sdm_detail'
                        ],
                        2 => [
                            'table' => 'tbl_detail_sdm_1',
                            'parent' => 'id_sdm_detail',
                            'no' => 'no_urut_1_sdm',
                            'nama' => 'nama_uraian_1_sdm',
                            'awal' => 'nilai_sdm_detail_1',
                            'add' => "nilai_sdm_detail_1_add_" . $roman,
                            'id' => 'id_detail_sdm_1'
                        ],
                    ]
                ];
        }

        return [];
    }




    public function get_adendum_by_kontrak($id_kontrak)
    {
        return $this->db_kms
            ->where('id_kontrak', $id_kontrak)
            ->where('no_adendum !=', 'kontrak_awal')
            ->order_by('no_adendum', 'ASC')
            ->get('table_adendum')
            ->result();
    }

    public function insert_main($data)
    {
        $this->db->insert('tbl_daftar_km', $data);
        return $this->db->insert_id();
    }

    public function insert_detail($data)
    {
        $this->db->insert('tbl_detail_daftar_km', $data);
        return $this->db->insert_id();
    }

    public function insert_rencana($data)
    {
        return $this->db->insert('tbl_detail_rencana_km', $data);
    }

    public function generateKode($table, $field, $prefix)
    {
        $this->db->select($field);
        $this->db->like($field, $prefix, 'after');
        $this->db->order_by($field, 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            $last = $query->row()->$field;
            $num = (int) substr($last, strlen($prefix)) + 1;
        } else {
            $num = 1;
        }

        return $prefix . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function cekSudahAda($id_kontrak, $level_daftar_km)
    {
        return $this->db
            ->where('id_kontrak', $id_kontrak)
            ->where('level_daftar_km', $level_daftar_km) // ⬅ tambahan cek level
            ->from('tbl_daftar_km')
            ->count_all_results();
    }
}
