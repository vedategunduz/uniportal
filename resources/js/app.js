import './bootstrap';
import 'flowbite';

window.addEventListener('click', function (event) {
    if (event.target.matches(".open-modal")) { const e = document.getElementById(event.target.dataset.modal); e.classList.remove("hidden"), e.classList.add("flex"), document.body.classList.add("overflow-hidden") } if (event.target.matches(".close-modal")) { const e = document.getElementById(event.target.dataset.modal); e.classList.remove("flex"), e.classList.add("hidden"), document.body.classList.remove("overflow-hidden") }
});
