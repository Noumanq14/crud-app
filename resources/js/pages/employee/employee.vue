<template>
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary mt-2" @click="goTo('AddNewEmployee')">Add New Employee</button>
        </div>
    </div>
</template>
<script>
    import { useRouter } from "vue-router";
    import { ref,onMounted,reactive } from "vue";
    import axios from "axios";
    import {UserStore} from "@/store/UserStore.js";

    export default {
        setup(){
            const router = useRouter();
            const employees = ref('');
            const store = UserStore();
            let token = store.token;

            let employeeId = ref('');
            let errors = ref('');

            const config = {
                headers: {
                    Authorization: "Bearer "+token
                }
            }

            function goTo(pageName){
                router.push({name:pageName});
            }

            return {
                goTo
            }
        }
    }

</script>
