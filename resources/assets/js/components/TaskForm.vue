<template>
   <div class="container">
        <transition name="fade">
            <div class="alert alert-danger message" role="alert" v-if="error" v-model="error">
                <strong>Oh snap!</strong> Please, fell out all fields. 
            </div>
        </transition>
        <transition name="fade">
            <div class="alert alert-danger message" role="alert" v-if="error404" v-model="error404">
                <strong>Error 404!</strong> 
            </div>
        </transition>
        <transition name="fade">
            <div class="alert alert-success message" role="alert" v-if="success" v-model="success">
                <strong>Well done!</strong> You successfully read <a href="#" class="alert-link">this important alert message</a>.
            </div>
        </transition>
        <h1>Task editor</h1>
        <form class="needs-validation" novalidate="" methos="post" action="http://makertask/tasks/add" @submit.prevent="createTask">
            
            
        <div class="row">
            <div class="col-md-8 mb-6">
                <label for="task_name">Task name</label>
                <input type="text" class="form-control" id="task_name" name="name" placeholder="" v-model="task.name" required="" >
            </div>
                    
            <div class="col-md-4 mb-6">
                <label for="task_time">Task time (in minutes)</label>
                <input type="number" class="form-control" id="task_time" name="start" placeholder="" min="1" required="" v-model="task.time" >
            </div>
        </div>
        <div class="row">
          <div class="col-md-12 mb-12">
            <label for="task_description">Description</label>
            <textarea class="form-control" id="task_description" name="description" v-model="task.description" placeholder="" required="" ></textarea >
           </div>
        </div>

        <hr class="col-md-12 mb-12">
        <div class="row">
            <div class="col-md-6 mb-12">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Save</button>
            </div>
        </div>
        <div class="clearfix"></div>
       
        
    </form>
    
        
    </div>
</template>


<script>
    import axios from 'axios'
    export default {
        data(){
            return{
                task:{
                    name: '',
                    description: '',
                    time: 1
                },
                //message flags
                error: false,
                success: false,
                error404: false
            }
        },
        computed:{
            id(){
                return +(window.location.href.split('/')[4])//get task id from url
            }
        },
        beforeMount: function(){
            if(Number.isInteger(+this.id)){
                this.getTask();
            }
        },
        methods: {
            //create new object task
            createTask: function(){
                if(this.task.name != '' && this.task.description != '' && this.task.time != '' && this.task.time >=1){
                    if(Number.isInteger(+this.id)){//if id isset in url sending ajax request to update task 
                        axios.put('http://makertask/tasks/'+this.id+'/update', {name: this.task.name, description: this.task.description, time: this.task.time})
                            .then(()=> this.success = true)
                            .catch(() =>  this.error404 = true);
                    }else{//if id isn't in url sending ajax request to create new task 
                        axios.post('http://makertask/add', {name: this.task.name, description: this.task.description, time: this.task.time})
                        .then(()=>{
                            //set empty task object and show success message 
                            this.task.name = '';
                            this.task.description = '';
                            this.task.time = 1;
                            this.success = true;
                        })
                        .catch(() =>  this.error404 = true);
                    }
                        //hide message
                        setTimeout(()=>{
                        this.success = false;
                        this.error404 = false;
                    }, 2000);
                    this.error = false;
                }
                else{
                   this.error = true;
                   //hide message
                   setTimeout(()=>{
                        this.error= false;
                    }, 2000);
                   this.success = false; 
                }
                  
            },
            //get task from DB for id 
            getTask: function(){
                axios.get('http://makertask/gettask/'+this.id)
                    .then((response)=>this.task = response.data)
                    .catch(() => this.error404 = true);
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
