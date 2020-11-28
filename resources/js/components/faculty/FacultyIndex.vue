<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>List of Faculties</h4>
                        <div>
                            <button @click="newFaculty()" class="btn btn-sm btn-dark">Create New Faculty</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ID Number</th>
                                    <th>Name</th>
                                    <th>Cluster(s)</th>
                                    <th>Institution</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="(teacher, index) in teachers" v-bind:key="teacher.id">
                                            <td>{{index+1}}</td>
                                            <td>{{teacher.id_number}}</td>
                                            <td>{{teacher.last_name}}, {{teacher.first_name}} {{teacher.middle_name}}.</td>
                                            <td><p v-for="cluL in teacher.clusters" v-bind:key='cluL.id'>{{cluL.cluster}}</p></td>
                                            <td>{{teacher.institution.institution}}, {{teacher.institution.address}} <b>({{teacher.institution.type}})</b></td>
                                            <td>{{teacher.status}}</td>
                                            <td>
                                                <button @click="viewFaculty(teacher)" class="btn btn-primary btn-sm">View</button>
                                                <button @click="editFaculty(teacher)" class="btn btn-warning btn-sm">Edit</button>
                                            </td>
                                        </tr>
                                    <tr>
                                        <td>No Faculties to Show</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row justify-content-center">
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- View Faculty Modal-->
        <div class="modal fade" id="viewFaculty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Faculty</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="v-id">ID:</label>
                                <input id="v-id" v-model="form.id" type="text" name="v-id"
                                    placeholder="ID"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-id') }" readonly>
                                    <has-error :form="form" field="v-id"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-idno">ID Number:</label>
                                <input id="v-idno" v-model="form.id_number" type="text" name="v-idno"
                                    placeholder="ID Number..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-idno') }" readonly>
                                    <has-error :form="form" field="v-idno"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-firstname">Firstname</label>
                                <input id="v-firstname" v-model="form.first_name" type="text" name="v-firstname"
                                    placeholder="Firstname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-firstname') }" readonly>
                                    <has-error :form="form" field="v-firstname"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-lastname">Lastname</label>
                                <input id="v-lastname" v-model="form.last_name" type="text" name="v-lastname"
                                    placeholder="Lastname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-lastname') }" readonly>
                                    <has-error :form="form" field="v-lastname"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="m-middle">Middlename</label>
                                <input id="m-middle" v-model="form.middle_name" type="text" name="m-middle"
                                    placeholder="Middlename"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('m-middle') }" readonly>
                                    <has-error :form="form" field="m-middle"></has-error>
                            </div>
                            <div v-for="(clu, index) in cluster" v-bind:key="clu.key" class="form-group">
                                <label for="c-step">Cluster #{{index+1}}</label>
                                <input id="c-step" type="text" name="c-step"
                                    placeholder="Step name..." v-bind:value="clu"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-step') }" readonly>
                                    <has-error :form="form" field="c-step"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Institution</label>
                                <input id="c-step" v-model="form.institution.institution" type="text" name="c-step"
                                    placeholder="Step name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-step') }" readonly>
                                    <has-error :form="form" field="c-step"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Status</label>
                                <input id="c-step" v-model="form.status" type="text" name="c-step"
                                    placeholder="Step name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-step') }" readonly>
                                    <has-error :form="form" field="c-step"></has-error>
                            </div>
                            <div v-if="ad_pan.length>0" class="form-group">
                                <label for="c-step">Adviser/Panel:</label>
                                <div>
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="ad in ad_pan" v-bind:key="ad.id">Tracking Step: <a v-bind:href="'/viewStep/'+ad.tracking_step_id">{{ad.tracking_step_id}}</a><b> (Role:{{ad.role}})</b></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Faculty Modal-->
        <div class="modal fade" id="editFaculty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Faculty</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveEdit()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="v-id">ID:</label>
                                <input id="v-id" v-model="form.id" type="text" name="v-id"
                                    placeholder="ID"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-id') }" readonly>
                                    <has-error :form="form" field="v-id"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-idno">ID Number:</label>
                                <input id="v-idno" v-model="form.id_number" type="text" name="v-idno"
                                    placeholder="ID Number..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-idno') }">
                                    <has-error :form="form" field="v-idno"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-firstname">Firstname</label>
                                <input id="v-firstname" v-model="form.first_name" type="text" name="v-firstname"
                                    placeholder="Firstname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-firstname') }">
                                    <has-error :form="form" field="v-firstname"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-lastname">Lastname</label>
                                <input id="v-lastname" v-model="form.last_name" type="text" name="v-lastname"
                                    placeholder="Lastname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-lastname') }">
                                    <has-error :form="form" field="v-lastname"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="m-middle">Middlename</label>
                                <input id="m-middle" v-model="form.middle_name" type="text" name="m-middle"
                                    placeholder="Middlename"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('m-middle') }">
                                    <has-error :form="form" field="m-middle"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="m-email">Email</label>
                                <input id="m-email" v-model="form.email" type="text" name="m-email"
                                    placeholder="email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('m-email') }">
                                    <has-error :form="form" field="m-email"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="m-contact_number">Contact</label>
                                <input id="m-contact_number" v-model="form.contact_number" type="text" name="m-contact_number"
                                    placeholder="contact_number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('m-contact_number') }">
                                    <has-error :form="form" field="m-contact_number"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Cluster(s):</label>
                                <span>
                                    <div class="form-check" v-for="clu in clustersList" v-bind:key="clu.id">
                                        <input  v-model="form.clusterF" type="checkbox" v-bind:value="clu.id" :checked="cluster.includes(clu.id)">
                                        <span class="checkbox-label">{{clu.cluster}}</span><br>
                                    </div>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Institution</label>
                                <select class="custom-select my-1 mr-sm-2" id="e-status" name="status" v-model="form.institution">
                                    <option v-for="ins in institutions" v-bind:key="ins.id" v-bind:value="ins.id">{{ins.institution}}, {{ins.address}} <b>({{ins.type}})</b></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Status</label>
                                <select class="custom-select my-1 mr-sm-2" id="e-status" name="status" v-model="form.status">
                                    <option value="1" class="form-control">Active</option>
                                    <option value="0" class="form-control">Inactive</option>
                                </select>
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
        <!-- New Faculty Modal-->
        <div class="modal fade" id="newFaculty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Faculty</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveNewFaculty()">
                        <div class="modal-body">
                            <div v-if="message"><font color="red">{{message}}</font></div>
                            <div class="form-group">
                                <label for="v-idno">ID Number:(Optional)</label>
                                <input id="v-idno" v-model="form.id_number" type="text" name="v-idno"
                                    placeholder="ID Number..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-idno') }">
                                    <has-error :form="form" field="v-idno"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-firstname">Firstname</label>
                                <input id="v-firstname" v-model="form.first_name" type="text" name="v-firstname"
                                    placeholder="Firstname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-firstname') }" required>
                                    <has-error :form="form" field="v-firstname"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="v-lastname">Lastname</label>
                                <input id="v-lastname" v-model="form.last_name" type="text" name="v-lastname"
                                    placeholder="Lastname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('v-lastname') }" required>
                                    <has-error :form="form" field="v-lastname"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="m-middle">Middlename</label>
                                <input id="m-middle" v-model="form.middle_name" type="text" name="m-middle"
                                    placeholder="Middlename"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('m-middle') }" required>
                                    <has-error :form="form" field="m-middle"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="m-email">Email</label>
                                <input id="m-email" v-model="form.email" type="text" name="m-email"
                                    placeholder="email"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('m-email') }" required>
                                    <has-error :form="form" field="m-email"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="contact_number">Contact</label>
                                <input id="contact_number" v-model="form.contact_number" type="text" name="contact_number"
                                    placeholder="contact_number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('contact_number') }" required>
                                    <has-error :form="form" field="contact_number"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Cluster(s):</label>
                                <span>
                                    <div class="form-check" v-for="clu in clustersList" v-bind:key="clu.id">
                                        <input  v-model="form.cluster" type="checkbox" v-bind:value="clu.id">
                                        <span class="checkbox-label">{{clu.cluster}}</span><br>
                                    </div>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Institution</label>
                                <select class="custom-select my-1 mr-sm-2" id="e-status" name="status" v-model="form.institution" required>
                                    <option v-for="ins in institutions" v-bind:key="ins.id" v-bind:value="ins.id">{{ins.institution}}, {{ins.address}} <b>({{ins.type}})</b></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="c-step">Status</label>
                                <select class="custom-select my-1 mr-sm-2" id="e-status" name="status" v-model="form.status" required>
                                    <option value="1" class="form-control">Active</option>
                                    <option value="0" class="form-control">Inactive</option>
                                </select>
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
</template>
<script>
export default {
    data(){
        return{
            teachers: {},
            cluster: [],
            clustersList: {},
            institutions: {},
            institute: '',
            message: '',
            ad_pan: {},
            form: new Form({
                id: '',
                id_number: '',
                first_name: '',
                last_name: '',
                middle_name: '',
                email: '',
                contact_number: '',
                institution: '',
                status: '',
                clusterF: {},
                cluster: []
            })
        }
    },
    methods: {
        getFaculties(){
            axios.get('api/getFaculties')
            .then(response => this.teachers = response.data);
        },
        getClusters(){
            axios.get('api/getClusters')
            .then(response => this.clustersList = response.data)
        },
        getInstitutions(){
            axios.get('api/getInstitutions')
            .then(response => this.institutions = response.data)
        },
        viewFaculty(teacher){
            this.form.reset();
            $('#viewFaculty').modal('show');
            this.form.fill(teacher);
            this.cluster=[];
            this.ad_pan={};
            axios.post('api/checkReqFaculty/'+this.form.id)
            .then(response=>{
                this.ad_pan = response.data;
            });
            for(let i =0; i<teacher.clusters.length; i++){
                this.cluster.push(teacher.clusters[i].cluster);
            }
            this.form.cluster = this.cluster;
        },
        editFaculty(teacher){
            this.form.reset();
            $('#editFaculty').modal('show');
            this.form.fill(teacher);
            this.cluster=[];
            this.institute='';
            for(let i =0; i<teacher.clusters.length; i++){
                this.cluster.push(teacher.clusters[i].id);
            }
            if(teacher.status=='Active'){
                this.form.status='1';
            }else{
                this.form.status='0';
            }
            this.institute = teacher.institution_id;
            this.form.institution = this.institute;
            this.form.clusterF = this.cluster;
        },
        saveEdit(){
            this.form.post('api/saveEditFaculty/'+this.form.id)
            .then(()=>{
                $('#editFaculty').modal('hide');
                this.getFaculties();
            }).catch(()=>{

            });
        },
        newFaculty(){
            this.form.reset();
            $('#newFaculty').modal('show');
        },
        saveNewFaculty(){
            this.form.post('api/newFaculty')
            .then(response=>{
                this.message = response.data;
                this.getFaculties();
                $('#newFaculty').modal('hide');
            });
        }
    },
    created(){
        this.getFaculties();
        this.getClusters();
        this.getInstitutions();
    }
}
</script>
