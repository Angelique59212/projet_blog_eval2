/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../styles/app.scss';

// start the Stimulus application
import '/node_modules/bootstrap/dist/css/bootstrap.css';

const close = document.getElementById('close');
const message = document.querySelector('.alert-success, .alert-danger');

if (close) {
    function closeMessage() {
        close.style.display = 'none';
        message.remove();
    }

    close.addEventListener("click", () => closeMessage());
    setTimeout(()=> closeMessage(), 4000);
}

