// script.js
// Custom JavaScript for the To-Do List application

const handleSplashScreen = () => {
    document.body.style.visibility = "visible";
    document.body.style.opacity = "1";
}

const handleShowHidePassword = () => {
    const cta = document.getElementById('cta-show-hide-password');
    const openEye = document.getElementById('open-eye');
    const closeEye = document.getElementById('close-eye');

    if (cta) {
        cta.addEventListener('click', () => {
            const passwordField = document.getElementById('password');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                openEye.style.display = 'block';
                closeEye.style.display = 'none';
            } else {
                passwordField.type = 'password';
                openEye.style.display = 'none';
                closeEye.style.display = 'block';
            }
        });
    }
}

const handleDeleteModal = () => {
    $(document).ready(function () {
        $(".modal-edit-trigger, .modal-delete-trigger").on("click", function () {
            let taskId = $(this).data("id");
            let taskTitle = $(this).data("title");
            let taskDescription = $(this).data("description");
            let taskDeadline = $(this).data("deadline");
            let taskAttachment = $(this).data("attachment");

            $("#modal-title").text(taskTitle);
            $("#modal-description").text(taskDescription);
            $("#modal-deadline").text("Tenggat Waktu: " + taskDeadline);
            $("#modal-attachment").attr("href", taskAttachment).text(taskAttachment.split("/").pop());

            $("#deleteModal").removeClass("hidden").addClass("flex");
            $("body").css("overflow", "hidden");
        });

        $("#closeModal").on("click", function () {
            $("#deleteModal").addClass("hidden").removeClass("flex");
            $("body").css("overflow", "auto");
        });

        $("#deleteModal").on("click", function (e) {
            if ($(e.target).is("#deleteModal")) {
                $("#deleteModal").addClass("hidden").removeClass("flex");
                $("body").css("overflow", "auto");
            }
        });
    });
}

handleSplashScreen();
handleShowHidePassword();
handleDeleteModal();