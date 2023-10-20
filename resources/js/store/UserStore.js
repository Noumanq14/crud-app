import { defineStore } from "pinia";

export const UserStore = defineStore({
    id:'UserStoreId',

    state: () => ({
        token: localStorage.getItem('token') || null,
    }),

    getters: {
        getToken: state => state.token
    },

    actions: {
        setToken: function (token){
            this.token = token;
            localStorage.setItem('token',token);
        },
        removeToken: function (){
            this.token = null;
            localStorage.removeItem('token');
        }
    }
});
