<script>
    export default {
        name: "TodoAdd",
        data() {
            return {
                todo: {
                    subject: '',
                    description: '',
                    completed: false
                },
                showForm: false
            }
        },
        methods: {
            onAddNewTask(e) {
                e.preventDefault();
                e.stopPropagation();

                if (this.todo.subject === '') {
                    this.makeErrorToast('Subject can\'t be empty');
                    return;
                }

                this.$emit("eventAddNewTodo", JSON.parse(JSON.stringify(this.todo)));

                this.onReset();
            },
            onReset() {
                this.todo.subject = '';
                this.todo.description = '';
                this.todo.completed = false;

                this.toggleForm();
            },
            makeErrorToast(message) {
                this.$bvToast.toast(message, {
                    title: 'Error',
                    autoHideDelay: 5000,
                    variant: 'danger',
                    solid: true
                });
            },
            toggleForm() {
                this.showForm = !this.showForm;
            }
        }
    }
</script>

<style lang="scss" scoped>
    #todoInputs {
        position: relative;

        > input {
            position: relative;
            border-bottom: 1px solid #ced4da;
            padding-right: 85px;
            margin-right: 38px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        > button {
            border-radius: 0;
            top: 0;
            right: 38px;
            position: absolute;
            background-color: transparent;
            border: 0;
            border-left: 1px solid #ced4da;
            color: #28a745;
            width: 38px;
            height: 38px;
            padding: 8px;

            &:active,
            &:hover {
                color: #24823f;
            }
        }

        > button.reset {
            right: 0;
            color: #dc3545;

            &:active,
            &:hover {
                color: #822431;
            }
        }

        > textarea {
            width: 100%;
            border-top: 0;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    }

    .showForm {
        border: 1px solid #e4eaf0;
        width: 100%;
        background-color: rgba(122, 250, 106, 0.03);
        color: #28a745;

        &:focus,
        &:active,
        &:hover {
            border: 1px solid #e4eaf0;
            background-color: rgba(107, 214, 105, 0.05) !important;
            color: #24823f !important;
        }
    }
</style>

<template>
    <div class="pb-3">
        <b-form id="todoInputs" @submit="onAddNewTask" @reset="onReset" v-if="showForm">
            <b-form-input v-model="todo.subject" type="text" placeholder="Subject"/>
            <b-button class="submit" variant="primary" type="submit">
                <font-awesome-icon icon="check"/>
            </b-button>
            <b-button class="reset" variant="danger" type="reset">
                <font-awesome-icon icon="times"/>
            </b-button>
            <b-form-textarea v-model="todo.description" placeholder="Description"/>
        </b-form>
        <b-button class="showForm" variant="primary" @click="toggleForm()" v-else>
            <font-awesome-icon icon="plus-circle"/>
        </b-button>
    </div>
</template>

