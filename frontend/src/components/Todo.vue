<script>
    export default {
        name: "Todo",
        props: {
            id: {
                type: Number,
                default: 0
            },
            subject: {
                type: String,
                default: ''
            },
            description: {
                type: String,
                default: ''
            },
            registered_at: {
                default: ''
            },
            completed: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            changeStatus() {
                this.$emit("eventTodoStatusChange", this.id, !this.completed);
            },
            deleteTodo() {
                this.$emit("eventTodoDelete", this.id);
            }
        }
    }
</script>

<style lang="scss" scoped>
    .list-group-item {
        position: relative;
        padding: 0.30rem 6.5rem 0.30rem 1rem;
    }

    button {
        border-radius: 0;
        top: 0;
        right: 0;
        position: absolute;
        background-color: transparent;
        border: 0;
        border-left: 1px solid #ced4da;
        color: #dc3545;
        width: 33px;
        height: 100%;
        padding: 5px;

        &:active,
        &:hover {
            border-left: 1px solid #ced4da;
            background-color: transparent !important;
            color: #822431 !important;
        }
    }

    button.completed {
        right: 33px;
        color: #28a745;

        &:active,
        &:hover {
            color: #24823f !important;
        }
    }

    button.notCompleted {
        right: 33px;
        color: #dc3545;

        &:active,
        &:hover {
            color: #822431 !important;
        }
    }

    button.description {
        right: 66px;
        color: #a6a6a6;

        &:active,
        &:hover {
            color: #828282 !important;
        }
    }

    .showForm {
        border: 1px solid #e4eaf0;
        width: 100%;
        background-color: rgba(122, 250, 106, 0.03);
        color: #28a745;

        &:active,
        &:hover {
            border: 1px solid #e4eaf0;
            background-color: rgba(107, 214, 105, 0.05);
            color: #24823f;
        }
    }
</style>

<template>
    <b-list-group-item class="text-left">
        <span>
            {{ subject }}
        </span>
        <b-button class="description" v-bind:id="'popover-target-' + id">
            <font-awesome-icon icon="info" size="xs"/>
        </b-button>
        <b-popover v-bind:target="'popover-target-' + id" triggers="hover" placement="top">
            <template v-slot:title>Description</template>
            {{ description }}
        </b-popover>
        <b-button class="notCompleted" @click="changeStatus" v-if="completed">
            <font-awesome-icon icon="times" size="xs"/>
        </b-button>
        <b-button class="completed" @click="changeStatus" v-else>
            <font-awesome-icon icon="check" size="xs"/>
        </b-button>
        <b-button class="delete" @click="deleteTodo">
            <font-awesome-icon icon="trash-alt" size="xs"/>
        </b-button>
    </b-list-group-item>
</template>

