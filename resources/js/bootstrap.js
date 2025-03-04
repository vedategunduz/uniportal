import fetchData from './fetch';
import * as alert from './alert';
import './echo';
import UniportalDropdown from './dropdown';
import './editor';
import FileUpload from './fileUpload.js';
import Cropper from 'cropperjs';

const dropdown = new UniportalDropdown();

const UniportalService = {
    dropdown,
    Cropper,
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
