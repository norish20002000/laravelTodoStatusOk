<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputtodo" v-model="todo_form">
                        <button type="button" class="btn btn-primary" @click="addTodo">Add</button>
                    </div>
                </div>
                <div class="card" v-for="todo in todos">
                    <div class="card-header">
                        <button type="button" class="btn btn-danger" @click="deleteTodo(todo.id)">Delete</button>
                        <button type="button" class="btn btn-info" @click="updateTodo(todo.id)">Update</button>
                        <input type="text" class="form-control" id="todo" v-model="todo.todo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import api from "../api.js"
    export default {
        data(){
            return {
                active_todo: null,
                todo_form:"",
                todos:[]
            }
        },
        methods:{
            addTodo(){
                let data = {todo:this.todo_form}
                data._token = document.getElementsByName('csrf-token')[0].content;
                // api.postTodo(JSON.stringify(data)).then(()=>{
                axios.post("/api/todo/", data).then((result)=>{
                    console.log(result);
                    this.getTodoList()
                })
            },
            deleteTodo(id){
                let data = {}
                data._token = document.getElementsByName('csrf-token')[0].content;
                // api.deleteTodo(id,JSON.stringify(data)).then(()=>{
                axios.delete('/api/todo/' + id, JSON.stringify(data)).then((result)=>{
                    console.log(result)
                    this.getTodoList()
                })
            },
            updateTodo(id){
                let data = {todo:this.todos.filter((v)=>{return v.id === id})[0].todo}
                data._token = document.getElementsByName('csrf-token')[0].content;
                // api.updateTodo(id,JSON.stringify(data)).then(()=>{
                axios.put('/api/todo/' + id, data).then((result)=>{
                    console.log(result)
                    this.getTodoList()
                })
            },
            getTodoList(){
                // api.getTodoList().then((result)=>{
                let data = {}
                data._token = document.getElementsByName('csrf-token')[0].content;
                axios.get("/api/todo/", data).then((result) => {
                    console.log(result);
                    this.todos = result.data
                })
            }
        },
        mounted() {
            this.getTodoList()
            console.log('Component mounted.')
        }
    }
</script>