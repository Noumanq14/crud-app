<template>
    <div class="container">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-primary mt-2" @click="goTo('AddNewCompany')">Add New Company</button>
        </div>

        <div class="col-lg-12">
            <h3 class="text-center">Companies</h3>
            <br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Company Email</th>
                        <th>Company Logo</th>
                        <th>Company Website</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="company in companies" :key="company.id">
                        <tr>
                            <td>{{company.name}}</td>
                            <td>{{company.email}}</td>
                            <td><img v-bind:src="company.logo" width="100" height="100"></td>
                            <td>{{company.website}}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#companyModal" @click="editCompany(company)">Edit</button>
                                <button type="button" class="btn btn-danger ms-2" @click="deleteCompany(company.id)">Delete</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="companyModal" tabindex="-1" aria-labelledby="companyModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="companyName"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" role="alert" v-for="error in errors" :key="error">
                            <span v-for="err in error" :key="err">{{err}}</span>
                        </div>
                        <form @submit.prevent="updateCompany" enctype="multipart/form-data">
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
                                <img v-bind:src="companyLogo" v-if="companyLogo != ''" width="100" height="100" class="mt-2">
                            </div>
                            <div class="form group">
                                <label for="companyWebsite">Website:</label>
                                <input type="text" class="form-control" id="companyWebsite" v-model="form.companyWebsite">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4" >Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { useRouter } from "vue-router";
    import { ref,onMounted,reactive } from "vue";
    import axios from "axios";
    import {UserStore} from "@/store/UserStore.js";
    export default {
        setup (){
            const router = useRouter();
            const companies = ref('');
            const store = UserStore();
            let token = store.token;
            let file = ref('');
            let companyId = ref('');
            let errors = ref('');
            let companyLogo = ref('');

            const form = reactive({
                companyName: '',
                email: '',
                companyWebsite: '',
                logo:''
            });

            const config = {
                headers: {
                    Authorization: "Bearer "+token,
                    'Content-Type': 'multipart/form-data'
                }
            }

            const onChange = (e)=>{
                file.value = e.target.files[0];
            }
            function goTo(pageName){
                router.push({name:pageName});
            }

            const getCompanies = async () => {
                await axios.get('/api/companies',config).then(res=>{
                    if (res.data.status == 1)
                        companies.value = res.data.data;
                });
            }

            function editCompany(company){
                $(".companyName").html("Edit "+company.name);
                form.companyName = company.name;
                form.email = company.email;
                form.companyWebsite = company.website;
                companyId.value = company.id;
                if (company.logo != "")
                {
                    companyLogo.value = company.logo
                    form.logo = company.logo
                }
            }

            const deleteCompany = async (companyId) => {
                await axios.delete('/api/companies/'+companyId,config).then(res=>{
                    if (res.data.status == 1)
                        getCompanies();
                }).catch(exception=>{
                    alert(exception.response.data.message);
                });
            }

            const updateCompany = async () => {
                let data = new FormData();

                data.append('name',form.companyName);
                data.append('email',form.email);
                data.append('companyWebsite',form.companyWebsite);
                data.append('file',file.value);
                data.append('logo',form.logo);
                data.append('_method','PATCH');

                await axios.post('/api/companies/'+companyId.value,data,config).then(res=>{
                    if (res.data.status == 1)
                    {
                        getCompanies();
                        $("#companyModal .btn-close").trigger("click");
                    }
                }).catch(exception=>{
                    errors.value = exception.response.data.message;
                });

            }

            onMounted(getCompanies)

            return{
                goTo,
                companies,
                editCompany,
                form,
                onChange,
                updateCompany,
                errors,
                companyLogo,
                deleteCompany
            }
        }
    }
</script>
