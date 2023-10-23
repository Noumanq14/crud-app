<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-4">
                <div class="alert alert-danger" role="alert" v-if="error">
                    {{ error }}
                </div>
                <form @submit.prevent="addNewCompany" enctype="multipart/form-data">
                    <div class="form group">
                        <label for="companyName">Name:</label>
                        <input type="text" class="form-control" id="companyName" v-model="form.companyName">
                    </div>
                    <div class="form group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form group">
                        <label for="companylogo">Logo:</label>
                        <input type="file" class="form-control" id="companylogo" @change="onChange">
                    </div>
                    <div class="form group">
                        <label for="companyWebsite">Website:</label>
                        <input type="text" class="form-control" id="companyWebsite" v-model="form.companyWebsite">
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
            let form = reactive({
                companyName: '',
                email: '',
                companyWebsite: '',

            });

            let error = ref('');
            let file = ref('');
            const store = UserStore();
            let token = store.token;

            const onChange = (e)=>{
                file.value = e.target.files[0];
            }

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    Authorization: "Bearer "+token
                }
            }

            const addNewCompany = async () => {

                let data = new FormData();
                data.append('name',form.companyName);
                data.append('email',form.email);
                data.append('companyWebsite',form.companyWebsite);
                data.append('file',file.value);
                console.log(data);

                await axios.post('/api/companies',data,config).then(res=>{
                    if (res.data.status == 1)
                        router.push({name: 'Company'});
                }).catch(exception=>{
                    if (exception.response.data.message.hasOwnProperty('name'))
                        error.value = exception.response.data.message.name[0];
                    else if(exception.response.data.message.hasOwnProperty('file'))
                        error.value = 'The Company logo is required.';
                    else
                        error.value = exception.response.data.message;
                });
            }

            return{
                form,
                onChange,
                addNewCompany,
                error
            }
        }

    }
</script>
