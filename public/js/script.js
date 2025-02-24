document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.getElementById("sidebar-overlay");

    menuToggle.addEventListener("click", function () {
        sidebar.classList.add("show");
        overlay.classList.add("show");
    });

    overlay.addEventListener("click", function () {
        sidebar.classList.remove("show");
        overlay.classList.remove("show");
    });
});
