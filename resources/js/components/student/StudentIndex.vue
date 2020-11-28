<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>List of Students</h4>
                        <div>
                            <button class="btn btn-dark btn-sm" @click="createstudent">Add Student</button>
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
                                    <th>Cluster</th>
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
                                            <td>#</td>
                                            <td>{{students.status}}</td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-sm">View</a>
                                                <!-- <a @click="editstudent()" class="btn btn-warning btn-sm">Edit</a> -->
                                                <button class="btn btn-warning btn-sm" @click="editstudent(student)">edit</button>
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
        
        <!-- Modal form for creating student -->
        <div class="modal fade" id="createstudent" tabindex="-1" role="dialog" aria-labelledby="createstudentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <!-- <form method="post" action="api/add"> -->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createstudentLabel">Add new student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="container">
            <form @submit.prevent="createstudent">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="id_number">ID Number</label>
                    <input type="number" name="id_number" class="form-control" id="id_number" value= ""
                        placeholder="Enter ID Number" v-model="students.id_number">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first_name"
                        value=""
                        placeholder="Enter First Name" v-model="students.first_name">
                </div>

            <div class="form-group col-md-4">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" id="middle_name"
                    value=""
                    placeholder="Enter Middle Name" v-model="students.middle_name">
            </div>

            <div class="form-group col-md-4">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name"
                    value=""
                    placeholder="Enter Last Name" v-model="students.last_name">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email"
                    value=""
                    placeholder="Enter Email" v-model="students.email">
            </div>

            <div class="form-group col-md-6">
                <label for="contact_number">Contact Number</label>
                <input type="number" name="contact_number" class="form-control" id="contact_number"
                    value=""
                    placeholder="Enter Contact Number" v-model="students.contact_number">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Select Clusters</label>
                <div class="border px-2 py-2">
                            <div class="custom-control custom-checkbox" v-for="clusters in cluster" v-bind:key="clusters.id">
                                <input type="checkbox" class="custom-control-input" id="cluster"
                                    name=""
                                    value=""
                                    v-model="clusters.cluster"
                                >
                                <label class="custom-control-label" for="cluster" >
                                    {{clusters.cluster}}
                                </label>
                            </div>
                        <p class="text-warning">No Course Available</p>
                </div>
        </div>
            <input type="hidden" name="" value="">
        </div>
        </form>
        </div> 
        </div>
        
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Student</button>
            </div>
        </div>
    </div>
    </div>
    <!-- end of create student modal -->

    <!-- Modal form for editing student -->
        <div class="modal fade" id="editstudent" tabindex="-1" role="dialog" aria-labelledby="editstudentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <!-- <form method="post" action="api/add"> -->
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editstudentLabel">Update student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="container">
            <form @submit.prevent="editstudent">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="id_number">ID Number</label>
                    <input type="number" name="id_number" class="form-control" id="id_number" value= ""
                        placeholder="Enter ID Number" v-model="students.id_number">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="first_name">First Name</label>
                    <input type="text" name="first_name" class="form-control" id="first_name"
                        value=""
                        placeholder="Enter First Name" v-model="students.first_name">
                </div>

            <div class="form-group col-md-4">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" id="middle_name"
                    value=""
                    placeholder="Enter Middle Name" v-model="students.middle_name">
            </div>

            <div class="form-group col-md-4">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="last_name"
                    value=""
                    placeholder="Enter Last Name" v-model="students.last_name">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email"
                    value=""
                    placeholder="Enter Email" v-model="students.email">
            </div>

            <div class="form-group col-md-6">
                <label for="contact_number">Contact Number</label>
                <input type="number" name="contact_number" class="form-control" id="contact_number"
                    value=""
                    placeholder="Enter Contact Number" v-model="students.contact_number">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label>Select Clusters</label>
                <div class="border px-2 py-2">
                            <div class="custom-control custom-checkbox" v-for="clusters in cluster" v-bind:key="clusters.id">
                                <input type="checkbox" class="custom-control-input" id="cluster"
                                    name=""
                                    value=""
                                    v-model="clusters.cluster"
                                >
                                <label class="custom-control-label" for="cluster">
                                    {{clusters.cluster}}
                                </label>
                            </div>
                        <p class="text-warning">No Course Available</p>
                </div>
        </div>
            <input type="hidden" name="" value="">
        </div>
        </form>
        </div> 
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    </div>
    <!-- end of edit student modal -->
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
            students:{
                id_number: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                email: '',
                contact_number:'',
                status:'',
                cluster:''
            }
    }
    },
    methods:{
        getstudent(){
            axios.get('studentlist')
            .then(response => this.student = response.data);
        },
        getcluster(){
           axios.get('clusterlist')
            .then(response => this.cluster = response.data); 
        },
        createstudent(){
            // this.form.reset();
            // let element = this.$refs.modal.$el
            // $(element).modal('show')
            $('#createstudent').modal('show')
            axios.post('add', {
                id_number: this.id_number,
                first_name: this.first_name,
                middle_name: this.middle_name,
                last_name: this.last_name,
                email: this.email,
                contact_number: this.contact_number
            })
        },
        editstudent(student){
            // let element = this.$refs.modal.$el
            // $(element).modal('show');
             $('#editstudent').modal('show')
            axios.post('student/'+this.student.id_number, {
                id_number: this.id_number,
                first_name: this.first_name,
                middle_name: this.middle_name,
                last_name: this.last_name,
                email: this.email,
                contact_number: this.contact_number
            });
        }
    },
    created(){
        this.getstudent();
        this.getcluster();
    }
}
</script>
