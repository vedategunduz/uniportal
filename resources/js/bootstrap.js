import './echo';
import './editor';
import './editor2';
import * as modal from './modal';
import * as alert from './alert';
import fetchData from './fetch';
import FileUpload from './fileUpload.js';
import UniportalDropdown from './dropdown';

const dropdown = new UniportalDropdown();

const UniportalService = {
    dropdown,
    modal,
}

const ApiService = {
    fetchData,
    alert,
}

window.ApiService = ApiService;
window.UniportalService = UniportalService;

document.querySelectorAll('[data-file-upload]').forEach(container => {
    new FileUpload(container);
});
