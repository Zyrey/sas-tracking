<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>List of Students</h4>
                        <div>
                            <button class="btn btn-dark btn-sm" @click="newStudent()">Add Student</button>
                            <!-- <StudentCreate ref="modal"></StudentCreate> -->
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID Number</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No.</th>
                                    <th>Cluster(s)</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="students in student" v-bind:key="students.id">
                                            <td>{{students.id_number}}</td>
                                            <td>{{students.last_name}}, {{students.first_name}} {{students.middle_name}}.</td>
                                            <td>{{students.email}}</td>
                                            <td>{{students.contact_number}}</td>
                                            <td v-if="students.clusters.length"><p v-for="stud in students.clusters" v-bind:key="stud.id">{{stud.cluster}}</p></td>
                                            <td v-else>N/A</td>
                                            <td>{{students.status}}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" @click="viewStudent(students)">View</button>
                                                <!-- <a @click="editstudent()" class="btn btn-warning btn-sm">Edit</a> -->
                                                <button class="btn btn-warning btn-sm" @click="editStudent(students)">Edit</button>
                                                <!-- <StudentEdit ref="modal"></StudentEdit> -->
                                            </td>
                                        </tr>
                                    <tr>
                                        <td>No Students to Show</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- View Student Modal -->
        <div class="modal fade" id="viewStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>ID Number</label>
                                        <input id="c-program" v-model="form.id_number" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                    <div class="col">
                                        <label>Cluster(s)</label>
                                        <ul>
                                            <div v-for="clu in clusterView" v-bind:key="clu.id">
                                                <li>{{clu.cluster}}</li>
                                            </div>
                                        </ul>
                                    </div>
                                    <div class="col">
                                        <label>Status</label>
                                        <input id="c-program" v-model="form.status" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Firstname</label>
                                        <input id="c-program" v-model="form.first_name" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                    <div class="col">
                                        <label>Lastname</label>
                                        <input id="c-program" v-model="form.last_name" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                    <div class="col">
                                        <label>Middlename</label>
                                        <input id="c-program" v-model="form.middle_name" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Email</label>
                                        <input id="c-program" v-model="form.email" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                    <div class="col">
                                        <label>Contact</label>
                                        <input id="c-program" v-model="form.contact_number" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
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
        <!-- Edit student modal -->
        <div class="modal fade" id="editStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveEditStudent()">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>ID Number</label>
                                        <input id="c-program" v-model="form.id_number" type="text" name="c-program"
                                        placeholder="Program name..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }">
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>Firstname</label>
                                            <input id="c-program" v-model="form.first_name" type="text" name="c-program"
                                            placeholder="Firstname..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Lastname</label>
                                            <input id="c-program" v-model="form.last_name" type="text" name="c-program"
                                            placeholder="Lastname..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Middlename</label>
                                            <input id="c-program" v-model="form.middle_name" type="text" name="c-program"
                                            placeholder="Middlename..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>Email</label>
                                            <input id="c-program" v-model="form.email" type="text" name="c-program"
                                            placeholder="Email..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Contact</label>
                                            <input id="c-program" v-model="form.contact_number" type="text" name="c-program"
                                            placeholder="Contact..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="c-step">Cluster(s):</label>
                                            <span>
                                                <div class="form-check" v-for="clu in cluster" v-bind:key="clu.id">
                                                    <input v-model="form.cluster" type="checkbox" v-bind:value="clu.id" :disabled="clusterCheck.includes(clu.id)">
                                                    <span class="checkbox-label">{{clu.cluster}}</span><br>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
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
        <!-- New student modal -->
        <div class="modal fade" id="newStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveNewStudent()">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>ID Number(Optional)</label>
                                        <input id="c-program" v-model="form.id_number" @change="checkId()" type="text" name="c-program"
                                        placeholder="ID Number..."
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }">
                                        <has-error :form="form" field="c-program"></has-error>
                                    </div>
                                </div>
                                <div v-if="id_data.length>0">
                                    <div class="row">
                                        <div class="col">
                                            <label>Firstname</label>
                                            <input id="c-program" type="text" name="c-program"
                                            placeholder="Firstname..." v-bind:value="id_data[0].first_name"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Lastname</label>
                                            <input id="c-program" v-bind:value="id_data[0].last_name" type="text" name="c-program"
                                            placeholder="Lastname..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Middlename</label>
                                            <input id="c-program" v-bind:value="id_data[0].middle_name" type="text" name="c-program"
                                            placeholder="Middlename..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>Email</label>
                                            <input id="c-program" v-bind:value="id_data[0].email" type="text" name="c-program"
                                            placeholder="Email..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Contact</label>
                                            <input id="c-program" v-bind:value="id_data[0].contact_number" type="text" name="c-program"
                                            placeholder="Contact..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="c-step">Cluster(s):</label>
                                                <span>
                                                    <div class="form-check" v-for="clu in cluster" v-bind:key="clu.id">
                                                        <input v-model="form.cluster" type="checkbox" v-bind:value="clu.id" :disabled="id_clusterCheck.includes(clu.id)">
                                                        <span class="checkbox-label">{{clu.cluster}}</span><br>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="row">
                                        <div class="col">
                                            <label>Firstname</label>
                                            <input id="c-program" v-model="form.first_name" type="text" name="c-program"
                                            placeholder="Firstname..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Lastname</label>
                                            <input id="c-program" v-model="form.last_name" type="text" name="c-program"
                                            placeholder="Lastname..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Middlename</label>
                                            <input id="c-program" v-model="form.middle_name" type="text" name="c-program"
                                            placeholder="Middlename..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label>Email</label>
                                            <input id="c-program" v-model="form.email" type="text" name="c-program"
                                            placeholder="Email..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                        <div class="col">
                                            <label>Contact</label>
                                            <input id="c-program" v-model="form.contact_number" type="text" name="c-program"
                                            placeholder="Contact..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" required>
                                            <has-error :form="form" field="c-program"></has-error>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="c-cluster">Choose a cluster</label>
                                            <span>
                                                <div class="form-check" v-for="clu in cluster" v-bind:key="clu.id" required>
                                                    <input v-model="form.cluster" type="checkbox" v-bind:value="clu.id">
                                                    <span class="checkbox-label">{{clu.cluster}}</span><br>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
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
</template>
<script>
export default {
    data (){
        return{
            cluster:[],
            clusters:{
                id:'',
                cluster:''
            },
            student: [],
            clusterCheck: [],
            clusterView: [],
            id_clusterCheck: [],
            id_data: {},
            form: new Form({
                id: '',
                id_number: '',
                first_name: '',
                last_name: '',
                middle_name: '',
                email: '',
                contact_number: '',
                status: '',
                original_id_number: '',
                cluster: [],
                id_data: []
            })
    }
    },
    methods:{
        getstudent(){
            axios.get('api/studentlist')
            .then(response => this.student = response.data);
        },
        getcluster(){
           axios.get('api/clusterlist')
            .then(response => this.cluster = response.data); 
        },
        viewStudent(data){
            this.form.reset();
            this.form.fill(data);
            let cluster = data.clusters;
            this.clusterView=[];
            for(let i=0;i<data.clusters.length;i++){
                this.clusterView[i] = cluster[i];
            }
            $('#viewStudent').modal('show');
        },
        editStudent(data){
            this.form.reset();
            this.form.fill(data);
            let cluster = data.clusters;
            this.clusterCheck=[];
            this.form.original_id_number = data.id_number;
            for(let i=0;i<data.clusters.length;i++){
                this.clusterCheck[i] = cluster[i].id;
            }
            this.form.cluster = this.clusterCheck;
            if(data.status=='Active'){
                this.form.status='1';
            }else{
                this.form.status='0';
            }
            $('#editStudent').modal('show');
        },
        saveEditStudent(){
            this.form.post('api/saveEditStudent')
            .then(response=>{
                this.getstudent();
                $('#editStudent').modal('hide');
            })
        },
        newStudent(){
            this.form.reset();
            $('#newStudent').modal('show');
        },
        disabledSelect(){
            if(this.form.cluster==""){
                return false;
            }else{
                return true;
            }
        },
        saveNewStudent(){
            this.form.post('api/saveNewStudent')
            .then(response=>{
                $('#newStudent').modal('hide');
                this.getstudent();
            })
        },
        checkId(){
            this.id_data = {};
            this.form.clear();
            axios.post('api/checkIdStudent/'+this.form.id_number)
            .then(response =>{
                this.id_data = response.data;
                this.id_clusterCheck = [];
                if(response.data.length){
                    for(let i=0; i< response.data[0].clusters.length; i++){
                        this.id_clusterCheck[i] = response.data[0].clusters[i].id;
                    }
                }
                
            });
            
        }
    },
    created(){
        this.getstudent();
        this.getcluster();
    }
}
</script>
