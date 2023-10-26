<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <div class="alert alert-danger" role="alert" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{err}}</span>
                </div>
                <form @submit.prevent="login">
                    <div class="form group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import {reactive,ref} from "vue";
    import axios from "axios";
    import { useRouter } from "vue-router";
    import { UserStore } from "@/store/UserStore.js";
    export default {
        setup(){
            const router = useRouter();
            const store = UserStore();
            let form = reactive({
                email: '',
                password: ''
            });

            let errors = ref('')

            const login = async () => {
                await axios.post('/api/login',form).then(res=>{
                    if (res.data.status == 1)
                    {
                        store.setToken(res.data.data.token);
                        store.setUserName(res.data.data.userName);
                        router.push({name: 'Dashboard'});
                    }
                }).catch(exception=>{
                    errors.value = exception.response.data.message;
                });
            }

            return{
                form,
                login,
                errors
            }
        }
    }
</script>
