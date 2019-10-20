import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        todos: []
    },
    mutations: {
        setTodos(state, payload) {
            state.todos = payload;
        }
    },
    actions: {
        getTodos({commit}) {
            Vue.axios.get('/todo').then((response) => {
                commit('setTodos', response.data);
            }).catch((err) => {
                throw new Error(err)
            });
        }
    },
    modules: {}
});
