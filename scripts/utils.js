function toggle_password() {
    button = document.getElementById("toggle-password");
    state = button.getAttribute("hide");

    icon = button.getElementsByTagName("svg")[0];

    input = document.getElementById("password");

    if (state == "true") {
        button.setAttribute("hide", "false");

        icon.classList.add("fa-eye-slash");
        icon.title = "Ocultar";

        password.setAttribute("type", "text");
    } else {
        button.setAttribute("hide", "true");

        icon.classList.add("fa-eye");
        icon.title = "Mostrar";

        password.setAttribute("type", "password");
    }
}