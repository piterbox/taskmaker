

require('./bootstrap');

import Vue from 'vue'
import Info from './components/Info'

new Vue({
    el: '#info',
    components: {
    	'info': Info
    }

});