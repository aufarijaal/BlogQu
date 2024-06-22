import "./bootstrap";
import "./libs/trix";
import "./blog-read-script";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.data("sanitizer", () => ({
    sanitizeTag: function (value) {
        return value.replace(/[^0-9a-zA-Z ]/g, "");
    },
}));
Alpine.start();
