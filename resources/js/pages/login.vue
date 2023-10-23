<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <div class="alert alert-danger" role="alert" v-if="error">
                    {{ error }}
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

            let error = ref('')

            const login = async () => {
                await axios.post('/api/login',form).then(res=>{
                    if (res.data.status == 1)
                    {
                        store.setToken(res.data.data.token);
                        router.push({name: 'Dashboard'});
                    }
                }).catch(exception=>{
                    if (exception.response.data.message.hasOwnProperty('email'))
                        error.value = exception.response.data.message.email[0];
                    else if(exception.response.data.message.hasOwnProperty('password'))
                        error.value = exception.response.data.message.password[0];
                    else
                        error.value = exception.response.data.message;
                });
            }

            return{
                form,
                login,
                error
            }
        }
    }
</script>
