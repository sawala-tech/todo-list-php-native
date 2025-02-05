document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM fully loaded and parsed");
    handleSplashScreen();
    handleShowHidePassword();
    handleModal("deleteTodo", ["id", "title", "description", "deadline", "attachment"]);
    handleModal("addTodo");
});

function handleSplashScreen() {
    document.body.style.visibility = "visible";
    document.body.style.opacity = "1";
}

function handleShowHidePassword() {
    const cta = document.getElementById("cta-show-hide-password");
    const passwordField = document.getElementById("password");
    const openEye = document.getElementById("open-eye");
    const closeEye = document.getElementById("close-eye");

    if (!cta || !passwordField || !openEye || !closeEye) return;

    cta.addEventListener("click", () => {
        const isPassword = passwordField.type === "password";
        passwordField.type = isPassword ? "text" : "password";
        openEye.style.display = isPassword ? "block" : "none";
        closeEye.style.display = isPassword ? "none" : "block";
    });
}

function handleModal(type, dataAttributes = []) {
    const triggers = document.querySelectorAll(`#${type}Trigger`); // Select all delete buttons
    const modal = document.getElementById(`${type}Modal`);
    const closeModal = document.getElementById(`close${capitalize(type)}Modal`);

    if (!triggers.length || !modal || !closeModal) return;

    triggers.forEach(trigger => {
        trigger.addEventListener("click", () => {
            if (dataAttributes.length) {
                dataAttributes.forEach(attr => {
                    const element = document.getElementById(`modal-${attr}`);
                    if (element) {
                        let value = trigger.dataset[attr];
                        if (attr === "deadline") {
                            value = new Date(value).toLocaleDateString("en-GB", {
                                day: "2-digit",
                                month: "short",
                                year: "numeric"
                            }).replace(/ /g, " ");
                        }
                        if (element.tagName === "A") {
                            element.setAttribute("href", value);
                            element.textContent = value.split("/").pop();
                        } else {
                            element.textContent = value;
                        }
                    }
                });
            }
            toggleModal(modal, true);
        });
    });

    closeModal.addEventListener("click", () => toggleModal(modal, false));
    modal.addEventListener("click", e => e.target === modal && toggleModal(modal, false));
}

function toggleModal(modal, show) {
    modal.classList.toggle("hidden", !show);
    modal.classList.toggle("flex", show);
    document.body.style.overflow = show ? "hidden" : "auto";
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}