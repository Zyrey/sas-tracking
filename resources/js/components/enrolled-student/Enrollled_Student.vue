<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>List of Students Enrolled this  (Current Semester)</h4>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Enrollment ID</th>
                                    <th>ID Number</th>
                                    <th>Name</th>
                                    <th>Program</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="enrollments in enrollment" v-bind:key="enrollments.id">
                                            <td>{{enrollments.id}}</td>
                                            <td>
                                                {{enrollments.student.id_number}}<a href=""></a>
                                            </td>
                                            <td>{{enrollments.student.last_name}}, {{enrollments.student.first_name}} {{enrollments.student.middle_name}}.</td>
                                            <td>{{enrollments.program.type}} in {{enrollments.program.program}}</td>
                                            <td>
                                                <!-- <router-link class="btn btn-primary btn-sm" v-bind:to="'TrackingShow'"> Manage Enrollments</router-link> -->
                                                <!-- <router-link class="btn btn-primary btn-sm" v-bind:to="{name:'StudentEnrollment', params: {id:enrollments.student.id_number}}"> Manage Enrollments</router-link> -->
                                                <a :href="'/students/'+enrollments.student.id_number+'/enrollments'" class="btn btn-primary btn-sm">Manage Enrollments</a>
                                                <!-- <button class="btn btn-primary btn-sm" @click="getenrolledcourse">Manage Enrollments</button> -->
                                            </td>
                                        </tr>
                                    <tr>
                                        <td>No Students to Show</td>
                                    </tr>
                                </tbody>
                            </table>
                            <router-view></router-view>
                            <div>
                                
                            </div>
                        </div>

                    </div>
                </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>No Current Semester</h5>
                            <a href="" class="btn btn-success btn-sm">Update Semester</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            enrollment:[],
            form :new Form({
                id:'',
                student:'',
                semester:'',
                program:'',
                course:'',
                enrolled:''
            })
        }
    },
    components:{
        
    },
    methods:{
        getenrollments(){
            axios.get('api/enrolledstudent')
            .then(response => this.enrollment = response.data);
        }
    },
    created(){
        this.getenrollments();
    }
}
</script>