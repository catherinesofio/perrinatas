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

function show_modal(type, title, body, footer = "") {
    modal_title = document.querySelector(".modal-title");
    modal_body = document.querySelector(".modal-body");
    modal_footer = document.querySelector(".modal-footer");

    modal_title.setAttribute("class", `modal-title text-${type}`);

    modal_title.innerHTML = title;
    modal_body.innerHTML = body;
    modal_footer.innerHTML = footer;

    $("#modal").modal("show");
}

function hide_modal() {
    $("#modal").modal({ show: false})
}

function change_tab(tab) {
    $(`#myTab button[data-target="#${tab}"]`).tab("show");
}

function scroll_top(id) {
    var element = document.getElementById(`${id}`);
    element.scrollTop = 0;
}

function scroll_bottom(id) {
    var element = document.getElementById(`${id}`);
    element.scrollTop = element.scrollHeight - element.clientHeight;
}