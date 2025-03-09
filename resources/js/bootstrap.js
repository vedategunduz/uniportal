import './echo';
import * as modal from './modal';
import * as alert from './alert';
import fetchData from './fetch';
import FileUpload from './fileUpload.js';
import UniportalDropdown from './dropdown';

const dropdown = new UniportalDropdown();

const fileUpload = new FileUpload();

const UniportalService = {
    dropdown,
    modal,
    fileUpload,
}

const ApiService = {
    fetchData,
    alert,
}

window.ApiService = ApiService;
window.UniportalService = UniportalService;
