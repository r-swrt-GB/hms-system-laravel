import '@mdi/font/css/materialdesignicons.css';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import {createVuetify} from 'vuetify';
import {VTimePicker} from "vuetify/labs/components";

export default createVuetify({
    components: {
        ...components,
        VTimePicker,
    },
    directives,
    theme: {
        themes: {
            light: {
                colors: {
                    primary: '#10439F',
                    secondary: '#fff',
                    error: '#B00020',
                    info: '#2196F3',
                    success: '#4CAF50',
                    warning: '#FB8C00',
                },
            },
            options: {
                customProperties: true,
                variations: false,
            }
        },
    },
})
