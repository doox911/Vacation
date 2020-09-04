import Vue from 'vue'
import vuetify from './plugins/vuetify'

import ExampleComponent from './components/ExampleComponent';

new Vue({
    vuetify,
    render: h => h(ExampleComponent)
}).$mount('#app')
