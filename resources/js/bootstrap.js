// Vue 3: Ya no se importa Vue aquí, se configura en app.js/system.js
import lodash from 'lodash';
import moment from 'moment';
import jquery from 'jquery';

window._ = lodash;
window.moment = moment;
window.$ = window.jQuery = jquery;

// Bootstrap JS no se usa - se está trabajando con Tailwind CSS
// Las funciones de tooltip/popover de Bootstrap no estarán disponibles
// Usa el-tooltip y el-popover de Element Plus en componentes Vue en su lugar

import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    window.headers_token = {
        'X-CSRF-TOKEN': token.content,
    }
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Vue 3: Las propiedades globales se configuran en app.js/system.js
// Vue.prototype.$http = axios; // Movido a app.js/system.js
// Vue.prototype.$setStorage = ... // Movido a app.js/system.js
// Vue.prototype.$getStorage = ... // Movido a app.js/system.js

// Exportar axios para uso en app.js/system.js
export { axios };

import './vendor/perfect-scrollbar.jquery.min';
import './vendor/sidebarmenu';
import './vendor/waves';
import './vendor/custom';

// parseXMLToJSON - Eliminado: xml-js causa problemas con módulos de Node.js (stream)
// Si necesitas parsear XML, usa la función directamente en el componente que lo necesite
// Ejemplo: import * as xmljs from 'xml-js' en el componente específico
// window.parseXMLToJSON ya no está disponible para evitar errores de carga

// Esperar a que jQuery esté disponible antes de usar $
(function initBootstrapJQuery() {
    if (window.$ || window.jQuery) {
        const $ = window.$ || window.jQuery;
        $(function () {
            const listElements = document.getElementsByClassName('nav-active');
            if (listElements.length > 0) {
                listElements[0].scrollIntoView();
            }
        });
    } else {
        // Reintentar después de un breve delay
        setTimeout(initBootstrapJQuery, 50);
    }
})();


const mercadopago = window.Mercadopago;

if(mercadopago)
{
    mercadopago.setPublishableKey(window.token_mercado_pago);
    mercadopago.getIdentificationTypes();
}
