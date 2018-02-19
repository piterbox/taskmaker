<template>
    <div id="app">
        <div class="container">
            <transition name="fade">
                <div class="alert alert-success message" role="alert" v-if="success" v-model="success">
                   Task have been deleted!
                </div>
            </transition>
            <h1>All tasks</h1>
            <div v-if="tasks.length != 0">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>State</th>
                            <th>
                               Direction 
                            </th>
                            <th>
                                Latest time
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(task, index, key) in tasks">
                            <transition name="fade">
                            <tr-task :task="task" v-on:isActive="activeTask" @selfdel="deleteTask($event)" :key></tr-task>
                            </transition>
                        </template>
                    </tbody>
                </table>
            </div>
            <div v-else>
                <h3>You have no tasks yet.</h3>
            </div>
        </div>
    </div>
</template>


<script>
    import Task from './Task.vue'
    import axios from 'axios'
    export default {
        components: {
            'tr-task': Task
        },
        data(){ 
            return{
                tasks:[],
                success: false
            }
        },
        beforeMount: function(){
            this.getTasks();
        },
        methods:{
            //set active task background color green
            activeTask: function(id){
                this.tasks.forEach(function(item, i){
                    item.active = false;
                    if(item.id == id){
                        item.active = true;
                    }
                });
            },
            //get new and paused tasks from DB 
            getTasks: function(){
                axios.get('http://makertask/tasks')
                .then((response)=> {this.tasks = response.data});
            },
            //delete task from list
            deleteTask(id){
                const numberTask = this.tasks.findIndex((elem)=>{
                    return elem.id == id;
                });
                this.tasks.splice(numberTask, 1);
                this.success = true;
                setTimeout(()=>{this.success = false}, 2000);
            },
        }
        

    }
        

</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity 1s;
    }
    .fade-enter, .fade-leave-to{
        opacity: 0;
    }
    
    h1{
        text-align: center;
        margin: 60px 0 40px;
    }
    .message{
        position: absolute;
        width: 100%;
        text-align: center;
    }
    .container{
        position: relative;
    }
</style>