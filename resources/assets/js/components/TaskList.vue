<template>
     <section>
        <div class="row justify-content-center">
            <div class="col-6">
                <h2 class="h2-responsive text-center p-3">My List of Tasks</h2>             
                <form action="#" @submit.prevent="addNewTask()">
                    <div class="input-group">
                        <input v-model="newTask.task" type="text" name="task" class="form-control">
                        <button type="submit" class="btn btn-primary">Add New Task</button>
                    </div>
                </form>
                <div class="mt-3">
                    <ul class="list-group">
                        <li v-if="incompletedTasks.length === 0" class="list-group-item d-flex justify-content-between align-items-center">There are no tasks yet!</li>               
                        <li v-for="task in incompletedTasks" :key="task.id" class="list-group-item d-flex justify-content-between align-items-center">
                            <div v-show="task.editable == false">{{ task.task }}</div>                 
                            <div>
                                <a href="#" @click="task.editable=true" v-show="task.editable == false" class="btn fa fa-edit"></a>
                                <a href="#" @click.prevent="toggleTask(task)" v-show="task.editable == false" class="btn fa fa-check"></a>
                                <a href="#" @click.prevent="deleteTask(task)" v-show="task.editable == false" class="btn fa fa-times"></a>
                            </div>
                            <div class="input-group" v-show="task.editable == true">
                                <input 
                                    type="text" 
                                    class="form-control"
                                    v-model="task.task" 
                                    v-on:blur="task.editable=false; uTask = task; updateTask(task); $emit('update')"
                                    @keyup.enter="task.editable=false; uTask = task; updateTask(task); $emit('update')">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">Update</button>
                                </div>
                            </div>            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div v-show="completedTasks.length > 0">
            <div class="row justify-content-center">
                <div class="col-6">
                    <h2 class="h2-responsive text-center p-3">Completed Tasks</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-6" style="opacity: .6;">
                    <ul class="list-group">
                        <li v-for="task in completedTasks" :key="task.id" class="list-group-item d-flex justify-content-between align-items-center">
                            {{ task.task }}
                            <div>
                                <span class="badge badge-success">completed</span>
                                <a href="#" @click.prevent="toggleTask(task)" class="btn fa fa-undo"></a>
                                <a href="#" @click.prevent="deleteTask(task)" class="btn fa fa-times"></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
        data() {
        return {
            incompletedTasks: [],
            completedTasks: [],
            uTask: [],
            cTasks: [],
            tasks: [],
            newTask: [
                {
                    task:'',
                    completed: '',
                    editable: ''
                }
            ]
        };
    },
    created() {
        // this.fetchAllTasks();
        this.getTasks();
    },
    methods: {
        getTasks(){
            axios.get('tasks').then(response => {
                this.tasks = response.data;
                this.completedTasks = this.tasks.filter(item => item.completed);
                this.incompletedTasks = this.tasks.filter(item => !item.completed);
            })
            .catch (error => {
                console.log(JSON.stringify(error));
            });
        },
        fetchIncompletedTasks(){
            axios.get('incompletedtasks').then(response => {
                this.incompletedTasks = response.data;
            })
            .catch (error => {
                console.log(JSON.stringify(error));
            });
        },
        fetchCompletedTasks(){
            axios.get('completedtasks').then(response => {
                this.completedTasks = response.data;
            })
            .catch (error => {
                console.log(JSON.stringify(error));
            });
        },
        fetchAllTasks(){
            this.fetchIncompletedTasks();
            this.fetchCompletedTasks();
        },
        addNewTask(){
            axios.post('store', {
                    task: this.newTask.task
                })
            .then(response => {
                this.newTask.task='';
                this.fetchAllTasks();
                toastr.options.closeButton = true;
                toastr.success('Your Task was Successfull Added');
            })
            .catch (error => {
                console.log(JSON.stringify(error));
            });
        },
        updateTask(task){
            axios.post('/update/' + task.id, {
                    task: this.uTask.task
                })
            .then(response => {
                this.uTask.task = '';
                this.fetchAllTasks();
                toastr.options.closeButton = true;
                toastr.success('Your Task was Updated');
            })
            .catch (error => {
                console.log(JSON.stringify(error));
            });
        },
        deleteTask(task){
            axios.get('/remove/' + task.id)
            .then(response => {
                this.fetchAllTasks();
                toastr.options.closeButton = true;
                toastr.error('Your Task was Removed');
            })
            .catch (error => {
                console.log(JSON.stringify(error));
            });
        },
        toggleTask(task){
            if (task.completed == false){
                axios.get('/completed/' + task.id)
                .then(response => {
                    this.fetchAllTasks();
                    toastr.options.closeButton = true;
                    toastr.success('Your Task is Completed');
                })
                .catch (error => {
                    console.log(JSON.stringify(error));
                });
            }
            else {
                axios.get('/completed/' + task.id)
                .then(response => {
                    this.fetchAllTasks();
                    toastr.options.closeButton = true;
                    toastr.success('Your Task was updated to incomplete');
                })
                .catch (error => {
                    console.log(JSON.stringify(error));
                });
            }            
        }
    }
}
</script>
