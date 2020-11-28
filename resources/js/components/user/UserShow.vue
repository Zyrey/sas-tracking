<template>
    <div class="container">
    <div class="row justify-content-center">



        <div class="col">
                <a v-bind:href="'/faculties'" class="btn btn-sm btn-dark">Back</a>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <h4></h4>
                    <div class="d-flex">
                        <div>
                            <button @click="editUserShow(user_data[0])" class="btn btn-sm btn-warning mr-2">Edit</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tbody v-if="user_data.length>0">
                            <tr>
                                <td>First Name:</td>
                                <td>{{user_data[0].first_name}}</td>
                            </tr>
                            <tr>
                                <td>Middle Name:</td>
                                <td>{{user_data[0].middle_name}}</td>
                            </tr>
                            <tr>
                                <td>Last Name:</td>
                                <td>{{user_data[0].last_name}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{this.user_email}}</td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>{{user_data[0].contact_number}}</td>
                            </tr>
                            <tr>
                                <td>Role:</td>
                                <td v-if="user_data[0].role_id">{{user_data[0].role_id}}</td>
                                <td v-else>N/A</td>
                            </tr>
                            <tr>
                                <td>Cluster:</td>
                                <td>{{user_data[0].cluster}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Edit User -->
        <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveEditedUser()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <div>
                                    <label for="c-sname">First name</label>
                                    <input id="c-sname" type="text" name="c-sname"
                                     v-model="form.first_name"
                                     placeholder="Step name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                    <has-error :form="form" field="c-sname"></has-error>
                                </div>
                                <div>
                                    <label for="c-sno">Middle name</label>
                                    <input id="c-sno" type="text"
                                    placeholder="Step number..."
                                     v-model="form.middle_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sno') }">
                                    <has-error :form="form" field="c-sno"></has-error>
                                </div>
                                <div>
                                    <label for="c-sno">Last name</label>
                                    <input id="c-sno" type="text"
                                    placeholder="Step number..."
                                     v-model="form.last_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sno') }">
                                    <has-error :form="form" field="c-sno"></has-error>
                                </div>
                                <div>
                                    <label for="c-sno">Email</label>
                                    <input id="c-sno" type="text"
                                    placeholder="Step number..."
                                     v-model="form.email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sno') }">
                                    <has-error :form="form" field="c-sno"></has-error>
                                </div>
                                <div>
                                    <label for="c-sno">Phone</label>
                                    <input id="c-sno" type="text"
                                    placeholder="Step number..."
                                     v-model="form.contact_number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sno') }">
                                    <has-error :form="form" field="c-sno"></has-error>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props: [
        'user_email'
    ],
    data(){
        return{
            user_data: {},
            roles: {},
            clusters: {},
            form: new Form({
                id: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                email: '',
                contact_number: '',
                role_id: '',
                cluster_id: '',
                original_id_number: ''
            })
        }
    },
    methods:{
        getUserData(){
            axios.post('../api/getUserData/'+this.user_email)
            .then(response=>{
                this.user_data = response.data
            })
        },
        editUserShow(data){
            this.form.reset();
            $('#editUser').modal('show');
            this.form.fill(data);
            if(data.role_id==null){
                this.form.role_id="";
            }
        },
        saveEditedUser(){
            this.form.post('../api/saveEditedUser')
            .then(response=>{
                $('#editUser').modal('hide');
                window.location = "/profile/"+this.form.email;
            })
        },
        getRoles(){
            axios.get('../api/getRoles')
            .then(response=>{
                this.roles = response.data
            })
        },
        getClusters(){
            axios.get('../api/getClusters')
            .then(response=>{
                this.clusters = response.data
            })
        }
    },
    created(){
        this.getUserData();
        this.getRoles();
        this.getClusters();
    }
}
</script>