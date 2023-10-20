<template>
    <div class="container">
        <h1>Welcome to Dashboard</h1>
        <button type="button" class="btn btn-dark mt-2" @click="logout">Logout</button>
    </div>
</template>
<script>
    import { useRouter } from "vue-router";
    // import { useStore } from "vuex";
    import { UserStore } from "@/store/UserStore.js";
    export default {
        setup(){
            const router = useRouter();
            const store = UserStore();
            function logout(){
                store.removeToken();
                router.push({name:'Home'});
            }

            return{
                logout
            }
        }
    }
</script>
