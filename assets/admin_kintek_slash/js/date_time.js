
    /* ============================================================
   AUTO DATE & TIME
============================================================ */
    function updateDateTime() {
        const now = new Date();

        const optionsDate = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric"
        };

        const optionsTime = {
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit"
        };

        const formattedDate = now.toLocaleDateString("id-ID", optionsDate);
        const formattedTime = now.toLocaleTimeString("id-ID", optionsTime);

        document.getElementById("dateTime").innerHTML =
            `<span>${formattedDate}</span> — <span>${formattedTime}</span>`;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
    
    
    /* ============================================================
   AUTO TEMPERATUR + NAMA LOKASI BERDASARKAN KOORDINAT USER
============================================================ */

    function getWeather(lat, lon) {
        const apiUrl =
            "https://api.open-meteo.com/v1/forecast?latitude=" + lat +
            "&longitude=" + lon + "&current_weather=true";

        fetch(apiUrl)
            .then(res => res.json())
            .then(data => {
                const temp = data.current_weather.temperature;
                const wind = data.current_weather.windspeed;

                // Lanjut ambil nama lokasi
                getLocationName(lat, lon, temp, wind);
            })
            .catch(() => {
                document.getElementById("weatherInfo").innerHTML =
                    "Gagal memuat data cuaca.";
            });
    }

    function getLocationName(lat, lon, temp, wind) {
        const url =
            `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=id`;

        fetch(url)
            .then(res => res.json())
            .then(loc => {
                let city = loc.city || loc.locality || loc.principalSubdivision || "Lokasi tidak diketahui";
                let country = loc.countryName || "";

                document.getElementById("weatherInfo").innerHTML =
                    `<i class="fa-solid fa-location-dot text-danger"></i> 
            <b>${city}${country ? ", " + country : ""}</b> — 
            <i class="fa-solid fa-temperature-half text-danger"></i> 
            Suhu: <b>${temp}°C</b>  
            <i class="fa-solid fa-wind text-primary"></i> 
            Angin: <b>${wind} km/h</b>`;
            })
            .catch(() => {
                document.getElementById("weatherInfo").innerHTML =
                    "Gagal memuat nama lokasi.";
            });
    }


    function requestLocation() {
        if (!navigator.geolocation) {
            document.getElementById("weatherInfo").innerHTML =
                "Browser tidak mendukung lokasi.";
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;

                document.getElementById("weatherInfo").innerHTML =
                    "Memuat suhu & lokasi...";
                getWeather(lat, lon);
            },
            () => {
                document.getElementById("weatherInfo").innerHTML =
                    "Izin lokasi ditolak.";
            }
        );
    }

    requestLocation();
    
    
    function updateFooterMargin() {
        const footer = document.querySelector(".content-footer");
        const sidebar = document.getElementById("sidebar");

        if (sidebar.classList.contains("collapsed")) {
            footer.style.marginLeft = "65px";
        } else {
            footer.style.marginLeft = "220px";
        }
    }

    // jalankan tiap toggle
    document.getElementById("toggleSidebar").addEventListener("click", () => {
        setTimeout(updateFooterMargin, 260);
    });

    // jalankan saat awal load
    updateFooterMargin();
    