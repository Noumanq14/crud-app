import { createStore } from 'vuex';

const store = createStore({
    state: {
        token: localStorage.getItem('token') || ""
    },
    mutations: {
        UPDATE_TOKEN(state,payload){
            state.token = payload;
        }
    },
    actions: {
        setToken(context,payload){
            localStorage.setItem('token',payload);
            context.commit('UPDATE_TOKEN',payload);
        },
        removeToken(context){
            localStorage.removeItem('token');
            context.commit('UPDATE_TOKEN',"");
        }
    },
    getters: {
        getToken: function (state){
            return state.token;
        }
    }
});

export default store;
