<template>
    <b-container>
        <b-row>
            <b-col>
                <h3>Todos</h3>
                <TodoAdd @eventAddNewTodo="onAddNewTodo"/>
                <b-list-group v-if="notEmpty()">
                    <Todo v-for="todo in getNotCompleted()" :key="todo.id" v-bind="todo"
                              @eventTodoStatusChange="onTodoStatusChange" @eventTodoDelete="onTodoDelete"/>
                </b-list-group>
            </b-col>
            <b-col>
                <h3>Completed</h3>
                <b-list-group>
                    <Todo v-for="todo in getCompleted()" :key="todo.id" v-bind="todo"
                              @eventTodoStatusChange="onTodoStatusChange" @eventTodoDelete="onTodoDelete"/>
                </b-list-group>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import store from '../store/index';
    import TodoAdd from '../components/TodoAdd.vue'
    import Todo from '../components/Todo.vue'

    export default {
        name: "Home",
        components: {
            TodoAdd,
            Todo
        },
        store,
        mounted() {
            store.dispatch('getTodos');
        },
        data() {
            return {
                todos: []
            }
        },
        methods: {
            onAddNewTodo(todo) {
                console.log(todo);
                this.axios
                    .put('/todo', todo, {headers: {'Content-Type': 'application/json'}})
                    .then((response) => {
                        store.state.todos.push(response.data)
                    })
                    .catch((err) => {
                        throw new Error(err)
                    });
            },
            onTodoStatusChange(id, completed) {
                let todo = store.state.todos.filter(i => i.id === id)[0];
                todo.completed = completed;

                this.axios
                    .post(`/todo`, todo, {headers: {'Content-Type': 'application/json'}})
                    .then(() => {})
                    .catch((err) => {
                        todo.completed = !completed;
                        throw new Error(err)
                    });
            },
            onTodoDelete(id) {
                this.axios
                    .delete(`/todo/${id}`)
                    .then(() => {
                        let index = store.state.todos.findIndex(i => i.id === id);
                        if (index > -1) {
                            store.state.todos.splice(index, 1)
                        }
                    })
                    .catch((err) => {
                        throw new Error(err)
                    });
            },
            getTodos() {
                return store.state.todos;
            },
            notEmpty() {
                return store.state.todos.length > 0;
            },
            getNotCompleted() {
                return store.state.todos.filter((todo) => !todo.completed)
            },
            getCompleted() {
                return store.state.todos.filter((todo) => todo.completed)
            }
        }
    }
</script>
