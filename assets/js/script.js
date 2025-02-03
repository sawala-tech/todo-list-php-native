// script.js
// Custom JavaScript for the To-Do List application

const splashScreen = () => {
    document.body.style.visibility = "visible";
    document.body.style.opacity = "1";
}

const showHidePassword = () => {
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

splashScreen();
showHidePassword();