<template>
   <transition name="slide">
   <tr :class="{'table-success':task.state == 'current', 'table-secondary': task.state == 'done', 'table-warning': task.state == 'paused'}" v-if="task"> 
        <td>{{task.name}}</td>
        <td>{{task.description}}</td>
        <td>{{task.state}}</td>
        <td>
            <div class="buttons">
                <button v-if="task.active"
                        @click.prevent="pauseTask"
                        type="button" 
                        class="btn btn-warning"
                        :class="{'disabled': task.state == 'done'}"
                ><i class="fa fa-pause" aria-hidden="true"></i>  Pause</button>

                <button v-else="!task.active"
                        @click.prevent="startTask"
                        type="button" 
                        class="btn btn-success"
                        :class="{'disabled': task.state == 'done'}"
                ><i class="fa fa-play-circle-o" aria-hidden="true"></i>  Start</button>

                <button @click.prevent="canselTask"
                        type="button"
                        class="btn btn-secondary"
                        :class="{'disabled': task.state == 'done'}"
                ><i class="fa fa-stop-circle-o" aria-hidden="true"></i>  Stop</button>

                <a :href="urlEdit" 
                    role="button"
                    class="btn btn-primary"
                ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></i></a>

                <a :href="urlDelete" 
                    role="button"
                    class="btn btn-danger"
                    @click.prevent="selfdelete"
                    
                ><i class="fa fa-times" aria-hidden="true"></i></a>
            </div>
        </td>
        <td>
            
            <span class="time"><strong>{{this.minutes}}:{{(this.seconds < 10 && this.seconds != null)? '0' : ''}}{{this.seconds != null ? this.seconds:'00' }}</strong></span>
            
            <div class="spinner">
                <i :class="{'fa fa-spin fa-spinner':task.state == 'current'}" aria-hidden="true"></i>
            </div>
        </td>
    </tr>
    </transition>
</template>

<script>
    export default {
        data(){
            return{
                interSec: '',
                interMin: '',
                seconds: this.task.seconds,
                minutes: (this.task.seconds != 0) ? this.task.time_left:this.task.time

            }
        },
        props: ['task'],//get task instance from parent (List)
        computed:{
            removeAlert(){
                this.error = false;
                this.success = false;
            },
            urlEdit(){
                return '/tasks/'+this.task.id+'/edit';
            },
            urlDelete(){
                return '/tasks/'+this.task.id+'/delete';
            },
            setMinutes(){
                if(this.task.time_left != null && this.task.seconds != null){
                    this.minutes = this.task.time_left
                }
                this.minutes = this.task.time;
            }
            
        },
        beforeUpdate:function(){
            if(this.task.active == false){
                clearInterval(this.interSec);
                clearInterval(this.interMin);
            }
            if(this.task.active == false && this.task.state == 'current'){
                this.task.state = 'paused';
            }
            
        },
        watch:{
            seconds:function(){
                if(this.minutes == 0){
                    if(this.seconds == 0){
                    clearInterval(this.interSec);
                    this.task.state = 'done';
                    this.canselTask();
                    }
                }
            },
        },
        methods: {
            //start the countdouwn for current task
            startTask(){
                this.task.active = true;
                this.task.state = 'current';
                
                if(this.minutes > 0){
                    this.minutes = this.minutes -1;
                }
                if(this.seconds != 0){
                    this.seconds =this.seconds-1;
                }
                else{
                    this.seconds = 59;
                }
                this.interMinTic();
                this.interSecTic();

                this.$emit('isActive', this.task.id);//send event to parent about starting task 
            },
            //set the task state done
            canselTask(){
                clearInterval(this.interMin);
                clearInterval(this.interSec);
                this.task.state = 'done';
                this.$emit('isActive', 0);
                this.updateDB();
                                
            },
            //set the task state pause
            pauseTask(){
                clearInterval(this.interMin);
                clearInterval(this.interSec);
                this.task.state = 'paused';
                this.$emit('isActive', 0);
                this.updateDB();
            },
            //set countdown to minutes
            interMinTic: function(){
                this.interMin = setInterval(()=>{
                    if(this.minutes >=0){
                        this.minutes = this.minutes -1;
                    }
                    
                }, 60000);
            },
            //set countdown to seconds
            interSecTic: function(){
                this.interSec = setInterval(()=>{
                    
                    if(this.minutes > 0 && this.seconds == 0){
                        this.seconds = 60;
                        
                    }
                    if(this.seconds > 0){ 
                        
                        this.seconds = this.seconds - 1;
                    }
                }, 1000);
            },
            //send ajax request to backend and updating task in DB
            updateDB: function(){
                this.task.time_left = this.minutes;
                this.task.seconds = this.seconds;
                axios.put('http://makertask/tasks/'+this.task.id+'/update', this.task);
                                        
            },
            //send ajax request to backend delete task from DB
            selfdelete: function(){
                this.$emit('selfdel', this.task.id);//send event to parent about deleting task
                axios.delete('http://makertask/tasks/'+this.task.id+'/delete');
            }
        }
        
    }
</script>

<style scoped>

    .slide-enter-active{
      transition: all 1s ease;
    }
    .slide-leave-active{
      transition: all .5s;
    }     
    .slide-enter{
      transform: translateY(50px);
      opacity: 0;
      
    }
    .slide-leave-to {
      transform: translateX(200px);
      opacity: 0;
      
    }

    .table-success{
        background-color: #89CFB3;
    }
    .table-warning{
        background-color: #FBE496;
    }
    .table-secondary{
        background-color: #d1d1d1;
    }
    i{
        margin: 0 5px 0 5px;

    }
    .time{
        font-size: 20px;
        padding: 5px;
    }
    .spinner{
        float: right;
    }
    .spinner i{
        font-size: 20px;
        color: red;
    }
    .buttons{
        min-width: 280px;
    }
    @media screen and(max-width: 768px){
       .buttons{
            max-width: 100px;
        } 
    }
   
</style>