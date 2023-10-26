<template>
    <div class="container">
        <h1>Welcome to Dashboard: {{store.userName}}</h1>
        <button type="button" class="btn btn-primary mt-2" @click="goTo('Company')">Company</button>
        <button type="button" class="btn btn-primary mt-2 ms-2" @click="goTo('Employee')">Employee</button>
        <button type="button" class="btn btn-dark mt-2 ms-2" @click="logout">Logout</button>
    </div>
</template>
<script>
    import { useRouter } from "vue-router";
    import { UserStore } from "@/store/UserStore.js";
    export default {
        setup(){
            const router = useRouter();
            const store = UserStore();
            function logout(){
                store.removeToken();
                store.removeUserName();
                router.push({name:'Home'});
            }

            function goTo(pageName){
                router.push({name:pageName});
            }

            return{
                logout,
                goTo,
                store
            }
        }
    }
</script>
