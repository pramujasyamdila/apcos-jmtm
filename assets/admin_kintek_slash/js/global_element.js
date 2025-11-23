/* ============================================================
   GLOBAL ELEMENT
============================================================ */
const sidebar = document.getElementById("sidebar");
const content = document.getElementById("content");

const userPic = document.getElementById("userPic");
const userDropdown = document.getElementById("userDropdown");

const notifBell = document.getElementById("notifBell");
const notifDropdown = document.getElementById("notifDropdown");
const notifBadge = document.getElementById("notifBadge");

const sidebarUserBtn = document.querySelector(".sidebar-user-btn");
const sidebarUserDropdown = document.getElementById("sidebarUserDropdown");

/* ============================================================
   RESET SUBMENU SAAT EXPANDED
============================================================ */
function resetSubmenuStyles() {
    document.querySelectorAll(".sidebar-submenu").forEach(sub => {
        sub.style.display = "";
        sub.style.opacity = "";
        sub.style.pointerEvents = "";
        sub.style.maxHeight = "";
        sub.style.transform = "";
    });
}

/* ============================================================
   SIDEBAR TOGGLE
============================================================ */
document.getElementById("toggleSidebar").onclick = () => {
    const collapsedBefore = sidebar.classList.contains("collapsed");

    if (window.innerWidth > 768) {
        sidebar.classList.toggle("collapsed");
        content.classList.toggle("full");

        if (collapsedBefore) resetSubmenuStyles();

    } else {
        sidebar.classList.toggle("show");
    }

    setTimeout(toggleTooltip, 250);
};

/* ============================================================
   SUBMENU CLICK (EXPANDED ONLY)
============================================================ */
document.querySelectorAll(".sidebar-toggle").forEach(link => {
    link.addEventListener("click", function (e) {

        if (sidebar.classList.contains("collapsed")) {
            e.preventDefault();
            return;
        }

        e.preventDefault();
        const submenu = this.nextElementSibling;
        submenu.classList.toggle("show");

        const icon = this.querySelector(".bi-chevron-down");
        if (icon) {
            icon.style.transform = submenu.classList.contains("show")
                ? "rotate(180deg)"
                : "rotate(0deg)";
        }
    });
});

/* ============================================================
   TOOLTIP
============================================================ */
const tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
const tooltipList = tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

function toggleTooltip() {
    if (sidebar.classList.contains("collapsed")) {
        tooltipList.forEach(t => t.enable());
    } else {
        tooltipList.forEach(t => t.disable());
    }
}
toggleTooltip();

/* ============================================================
   SUBMENU FLOATING SAAT COLLAPSED
============================================================ */
document.querySelectorAll(".nav-item").forEach(item => {

    item.addEventListener("mouseenter", function () {

        if (!sidebar.classList.contains("collapsed")) return;

        const submenu = this.querySelector(".sidebar-submenu");
        if (!submenu) return;

        // Tutup semua dulu
        document.querySelectorAll(".sidebar-submenu").forEach(s => {
            if (s !== submenu) {
                s.style.opacity = "0";
                s.style.pointerEvents = "none";
            }
        });

        submenu.style.display = "block";
        submenu.style.maxHeight = "600px";
        submenu.style.opacity = "1";
        submenu.style.pointerEvents = "auto";
        submenu.style.transform = "translateY(0)";
    });

    item.addEventListener("mouseleave", function () {

        if (!sidebar.classList.contains("collapsed")) return;

        const submenu = this.querySelector(".sidebar-submenu");
        if (!submenu) return;

        submenu.style.opacity = "0";
        submenu.style.pointerEvents = "none";
    });

});

/* ============================================================
   NOTIFICATION DROPDOWN
============================================================ */
if (notifBell) {
    notifBell.addEventListener("click", function (e) {
        e.stopPropagation();

        notifDropdown.style.display =
            notifDropdown.style.display === "block" ? "none" : "block";

        notifBadge.style.display = "none";

        if (userDropdown) userDropdown.style.display = "none";
        if (sidebarUserDropdown) sidebarUserDropdown.style.display = "none";
    });
}

document.addEventListener("click", () => {
    notifDropdown.style.display = "none";
});

/* ============================================================
   USER DROPDOWN NAVBAR
============================================================ */
if (userPic) {
    userPic.addEventListener("click", function (e) {
        e.stopPropagation();

        userDropdown.style.display =
            userDropdown.style.display === "block" ? "none" : "block";

        notifDropdown.style.display = "none";

        if (sidebarUserDropdown) sidebarUserDropdown.style.display = "none";
    });
}

/* CLICK OUTSIDE CLOSE — versi aman */
document.addEventListener("click", function (e) {
    if (
        userDropdown &&
        !userPic.contains(e.target) &&
        !userDropdown.contains(e.target)
    ) {
        userDropdown.style.display = "none";
    }
});

/* ============================================================
   USER DROPDOWN (SIDEBAR BOTTOM)
============================================================ */
if (sidebarUserBtn) {
    sidebarUserBtn.addEventListener("click", (e) => {
        e.stopPropagation();

        sidebarUserDropdown.style.display =
            sidebarUserDropdown.style.display === "block" ? "none" : "block";

        if (userDropdown) userDropdown.style.display = "none";
        notifDropdown.style.display = "none";
    });

    // Hover floating mode (collapsed only)
    sidebarUserBtn.addEventListener("mouseenter", function () {
        if (sidebar.classList.contains("collapsed")) {
            sidebarUserDropdown.style.display = "block";
        }
    });

    sidebarUserBtn.addEventListener("mouseleave", function () {
        if (sidebar.classList.contains("collapsed")) {
            sidebarUserDropdown.style.display = "none";
        }
    });
}

/* CLOSE SIDEBAR USER DROPDOWN SAAT KLIK LUAR */
document.addEventListener("click", function (e) {
    if (
        sidebarUserDropdown &&
        !sidebarUserBtn.contains(e.target) &&
        !sidebarUserDropdown.contains(e.target)
    ) {
        sidebarUserDropdown.style.display = "none";
    }
});
