import "./bootstrap";

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse"; //Import plugin collapse

Alpine.plugin(collapse); // Daftarkan plugin ke Alpine

window.Alpine = Alpine;
Alpine.start();
