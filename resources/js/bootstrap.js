// import axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
import fetchData from './fetch';
import * as alert from './alert';
import './echo';
import UniportalDropdown from './dropdown';

const dropdown = new UniportalDropdown();

const UniportalService = {
    dropdown
}

const ApiService = {
    fetchData,
    alert,
}

window.ApiService = ApiService;
window.UniportalService = UniportalService;

// new window.ApiService.UniportalDropdown;
