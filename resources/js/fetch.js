import axios from 'axios'

const BASE_URL = window.location.origin;
const CSRF_TOKEN = document.head.querySelector('meta[name="csrf-token"]').content;

axios.defaults.baseURL = BASE_URL;
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['X-CSRF-TOKEN'] = CSRF_TOKEN;
// axios.defaults.headers.common['Content-Type'] = 'application/json';

async function fetchData(URL, DATA = null, METHOD = 'GET') {
    try {
        let config = {
            method: METHOD,
            url: URL,
        };

        if (METHOD === 'GET' || METHOD === 'DELETE') {
            if (DATA)
                config.params = DATA;
        }
        else
        {
            config.data = DATA;

            if (DATA instanceof FormData) {
                config.headers = {
                    // axios, FormData gönderildiğinde Content-Type'ı otomatik ayarlayacaktır.
                };
            }
        }

        return await axios(config);
    } catch (error) {
        return {
            success: false,
            message: error.response.data.message
        };
    }
}

export default fetchData;
