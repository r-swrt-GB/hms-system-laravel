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
                dark: false,
                colors: {
                    primary: '#fff',
                    secondary: '#122A46',
                    error: '#B00020',
                    info: '#2196F3',
                    success: '#4CAF50',
                    warning: '#FB8C00',
                },
            },
            dark: {
                dark: true,
                colors: {
                    primary: '#fff',
                    secondary: '#4E4D5C',
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
