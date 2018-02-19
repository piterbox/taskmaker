<template>
    <div class="container">
        <div class="row">
            <h1>Information about tasks</h1>
            <div class="form-check form-check-inline">
                <div class="form-group">
                    <label for="fromtime" class="col-sm-2 col-form-label">Period from</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="" id="fromtime" v-model="periodfrom">
                    </div>
                    <label for="totime" class="col-sm-1 col-form-label">to</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" id="totime" v-model="periodto">
                    </div>
                    <button class="btn btn-primary" @click.prevent="getTasks">Show results</button>
                </div>
                <div class="form-group row">
                    
                </div>
            </div>

        </div>
        <transition name="slide"></transition>
        <div class="row" v-if="show">
            <h1>All tasks</h1>
            <div >
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>State</th>
                            <th>
                               Created
                            </th>
                            <th>
                               Planned time
                            </th>
                            <th>
                               Used time
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(task, index) in tasks">
                            <td>{{task.name}}</td>
                            <td>{{task.description}}</td>
                            <td>{{task.state}}</td>
                            <td>{{task.created}}</td>
                            <td>{{task.time}}:00 minutes</td>
                            <td>{{task.used_time}}:{{(60-task.seconds) < 10? '0':''}}{{task.seconds != 0 && task.state != 'new' ? 60-task.seconds:'00'}} minutes</td>
                        </tr>
                        
                    </tbody>
                </table>
                <h3>Total tasks: <strong>{{tasks.length}}</strong></h3>
                <h3>Total time for tasks complete: <strong>{{totalTime}}</strong> minutes</h3>
            </div>
        </div>
        </transition>

    </div>
</template>


<script>
    import axios from 'axios'
    export default {
        components: {
            
        },
        data(){ 
            return{
                periodfrom: '',
                periodto:'',
                tasks: [],
                show: false
                
            }
        },
        computed:{
            //set total used time to do tasks
            totalTime(){
                let seconds = 0;
                let minutes = 0;
                this.tasks.forEach(function(item){
                    if(item.seconds != 0){
                        seconds += +(60-item.seconds)
                    }
                    minutes += item.used_time;
                });
                
                let min = parseInt(seconds/60);
                let sec = seconds - min*60;
                
                if(sec<10){
                    sec = sec+'0';
                }
                return (minutes + min)+':'+sec;
            },
        },
        methods:{
            //get tasks from db 
            getTasks: function(){
                this.tasks = [];//delete tasks before get new tasks
                axios.post('http://makertask/tasks/info', {from:this.periodfrom, to:this.periodto})
                .then((response)=> {
                    this.tasks = response.data;
                    this.show = true;
                })
                .catch(()=>this.show = false);
            },
        }
    }
        

</script>

<style>
    .slide-enter-active{
      transition: all 2s;
    }
     
    .slide-enter{
      opacity: 0;
      transform: translateY(50px);
    }
    

    h1{
        text-align: center;
    }

</style>