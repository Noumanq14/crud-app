import { defineStore } from "pinia";

export const UserStore = defineStore({
    id:'UserStoreId',

    state: () => ({
        token: localStorage.getItem('token') || null,
        userName: localStorage.getItem('userName') || null
    }),

    getters: {
        getToken: state => state.token,
        getUserName: state => state.userName
    },

    actions: {
        setToken: function (token){
            this.token = token;
            localStorage.setItem('token',token);
        },
        removeToken: function (){
            this.token = null;
            localStorage.removeItem('token');
        },
        setUserName: function (userName){
            this.userName = userName;
            localStorage.setItem('userName',userName);
        },
        removeUserName: function (){
            this.userName = null;
            localStorage.removeItem('userName');
        }
    }
});
