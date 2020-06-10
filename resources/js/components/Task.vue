<template>
    <div>
        <div class="row justify-content-center"><h2 v-show="loaded==false">Loading ...</h2></div>
        <div class="row mb-2" v-for="task in tasks" :key="task.id" style="position:relative">
            <!-- Task Content -->
            <div class="row col-lg-8 col-sm-12 task" style="position:relative" :class="{ cannotEdit: task.id!=editIndex&&editIndex!=-1?true:false}" v-show="task.id!=editIndex">
                <p :class="{ isComplete: task.complete }" class="col-12 task__content" @click="editIndex=task.id">{{task.content}}</p>
                <div class="task__check" :class="{ completed: task.complete }" @click="complete(task)"></div>
            </div>
            <!-- Task Edit Content-->
            <div v-show="task.id==editIndex" class="col-lg-8 col-sm-12 row">
                <input type="text" name="content" class="add__text col-12" v-model="task.content">
            </div>
            <!-- Task Due Date  -->
            <div class="col-lg-3 col-sm-6 task__date" :class="{ isComplete: task.complete,cannotEdit: task.id!=editIndex&&editIndex!=-1?true:false}" @click="editIndex=task.id" v-show="task.id!=editIndex">
                <p :class="{ isComplete: task.complete }">{{task.due_date}}</p>
            </div>
            <!-- Task Edit Date -->
            <input type="date" name="due_date" class="add__date col-lg-3 col-sm-6" v-show="task.id==editIndex" v-model="task.due_date">
            <!-- Delete Button  -->
            <button type="button" class="btn btn-primary col-1" v-show="task.id!=editIndex" @click="deleteTask(task)">Delete</button>
            <!-- Edit Done Button  -->
            <button type="button" class="btn btn-success col-1" v-show="task.id==editIndex" @click="editFinished(task)">Done</button>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                tasks: [],
                loaded: false,
                editIndex: -1,
            }
        },
        methods : {
            complete: function(task){
                task.complete=!task.complete;
                axios.post('/updateTask', {
                    id: task.id,
                    content: task.content,
                    complete: task.complete,
                    due_date: task.due_date,
                })
            },
            editFinished: function(task){
                if(task.content=='')
                    this.deleteTask(task);
                else{
                    if(task.due_date=='')
                        task.due_date='0001-01-01';
                    this.editIndex = -1;
                    this.editDateIndex = -1;
                    axios.post('/updateTask', {
                        id: task.id,
                        content: task.content,
                        complete: task.complete,
                        due_date: task.due_date,
                    })
                }
            },
            deleteTask: function(task){
                var index = this.tasks.indexOf(task);
                this.tasks.splice(index,1);
                axios.post('/deleteTask', {
                    id: task.id,
                })
            },
        },
        watch: {
			tasks: function(){
				return this.tasks;
			}
	  	},
        mounted() {
            axios.get('/getIndex')
            .then( (response)=> {
                this.tasks = response.data;
                this.loaded=true;
                for(var i=0;i<this.tasks.length;i++)
                    this.tasks[i].editing = 0;
                console.log(this.tasks);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
        }
    }
</script>

<style scoped>
    .task__check{
        position: absolute;
        height: 25px;
        width:25px;
        border-radius:50%;
        border: 1px solid black;
        cursor: pointer;
        right: 20px;
        top:5px;
    }
    .isComplete{
        text-decoration: line-through;
    }
    div.isComplete,p.isComplete{
        pointer-events: none;
        background-color: #c7c7c7fc;
    }

    .completed::before{
        display: block;
        content: "";
        width: 15px;
        height: 20px;
        border: 5px solid #28a745;
        transform: rotate(45deg);
        position: absolute;
        top: 0px;
        left: 4px;
        border-top: none;
        border-left: none;
    }

    .task__content,.task__date{
        width: 100%;
        height: calc(1.6em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        font-weight: 400;
        line-height: 1.6;
        background-color: #ebebeb;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        margin-bottom: 0;
        cursor: pointer;
    }

    .cannotEdit{
        pointer-events: none;
    }

    @media only screen and (max-width: 425px) {
        .row{
            margin-right: -5px;
            margin-left: -5px;
            padding-right: unset;
        }

        .task{
            flex: none;
            max-width: 100%;
        }
        .task__date{
            margin-top: 2px;
            margin-left: 0.65rem;
            flex: none;
            max-width: 60%;
        }
        
    }
</style>