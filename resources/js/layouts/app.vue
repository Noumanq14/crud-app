<template>
    <div>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <router-link class="navbar-brand" :to="{ name: 'Home' }" >Home</router-link>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="text-white" style="text-decoration: none;" :to="{ name: 'Login' }" v-if="token == null">Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="text-white" style="margin-left: 10px;text-decoration: none;" :to="{ name: 'Dashboard' }" v-if="token != null">Dashboard</router-link>
                </li>
            </ul>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script>
    import { UserStore } from "@/store/UserStore.js";
    import { mapState } from "pinia";
    export default({
        computed: {
            ...mapState(UserStore,['token'])
        }
    });
</script>
