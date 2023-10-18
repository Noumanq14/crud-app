<script setup></script>
<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-4 mt-5">
                <form @submit.prevent="login">
                    <div class="from-group">
                        <label>Email</label>
                        <input class="form-control" type="email" v-model="form.email"/>
                    </div>
                    <div class="from-group">
                        <label>Password</label>
                        <input class="form-control" type="password" v-model="form.password"/>
                    </div>
                    <button type="submit" class="btn btn-dark mt-4">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import {reactive} from "vue";
import axios from "axios";
export default {
    setup(){
        const form = reactive({
            email:'',
            password:''
        });

        const login = async()=>{
            await axios.post("api/login",form).then((response)=>{
                console.log(response.data.message);
            }).catch((error)=>{
                let errorArray = error.response.data.errors;
                console.log(errorArray);
                // if (errorArray.includes("email"))
                //     console.log("Aaaa");
                // else
                //     console.log("asdads");
                // console.log(error.response.data.errors.includes("email"));
                // if (error.response.data.errors.email[0].length > 0)
                //     alert(error.response.data.errors.email[0]);
                // console.log(error.response.data.errors.password);
                // if (error.response.data.errors.password[0].length > 0)
                //     alert(error.response.data.errors.password[0]);
            })
        }

        return{
            form,
            login,
        }
    }
}
</script>
