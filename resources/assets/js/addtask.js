

require('./bootstrap');

import Vue from 'vue'
import TaskForm from './components/TaskForm'

new Vue({
    el: '#add_task',
    components: {
    	'task-form': TaskForm
    }

});