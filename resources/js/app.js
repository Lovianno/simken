// Bootstrap bawaan Laravel
import "./bootstrap";

// Bootstrap core JS
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

/* Sneat Core */
import "../sneat/js/helpers.js";
import "../sneat/js/config.js";
import "../sneat/js/menu.js";
import "../sneat/js/ui-toasts.js";
import "../sneat/js/ui-popover.js";
import "../sneat/js/pages-account-settings-account.js";
import "../sneat/js/extended-ui-perfect-scrollbar.js";
import "../sneat/js/main.js";

import AOS from "aos";
import "aos/dist/aos.css";

// Inisialisasi Sneat sidebar overlay dan AOS
document.addEventListener("DOMContentLoaded", () => {
    if (
        typeof window.Helpers !== "undefined" &&
        typeof window.Helpers.initSidebarToggle === "function"
    ) {
        window.Helpers.initSidebarToggle();
    }

    AOS.init({
        duration: 800, // durasi animasi (ms)
        once: true, // animasi hanya sekali
        offset: 120, // jarak trigger dari bawah viewport
    });
});
