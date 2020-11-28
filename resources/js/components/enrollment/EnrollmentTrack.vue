<template>
    <div class="card">
        <div class="card-header bg-primary">
            <h4>List of Enrollments for  (Current Semester)</h4>
            <div class="float-right">
                <button @click="updateEnrollment()" class="btn btn-dark btn-sm mr-1">Update Enrollment</button>
                <button v-if="checker=='1'" @click="newTracking()"
                    class="btn btn-dark btn-sm">
                    Create New Tracking
                </button>
                <form style="display: none" id="form-create-tracking" action="#">
                </form>
            </div>
        </div>
        <div class="card-body">
            <h6>
                <strong>
                    <p v-if='enrollment.student'>{{this.enrollment.student[0].year_start}} - {{this.enrollment.student[0].year_end}} Term: {{this.enrollment.student[0].term}}</p>
                </strong>
            </h6>
            <table class="table table-sm table-borderless">
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody v-if='enrollment.student'>
                    <tr>
                        <td><strong>Student Details</strong></td>
                    </tr>
                    <tr>
                        <td>ID Number:</td>
                        <td><a href="#">{{this.enrollment.student[0].id_number}}</a></td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td>{{this.enrollment.student[0].last_name}}, {{this.enrollment.student[0].first_name}} {{this.enrollment.student[0].middle_name}}</td>
                    </tr>
                    <tr>
                        <td>Program:</td>
                        <td>{{this.enrollment.student[0].program}}</td>
                    </tr>
                    <tr>
                        <td>Residency Period:</td>
                        <td>{{residency}} Days</td>
                    </tr>
                    <tr>
                        <td><strong>Enrollment Details</strong></td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>{{this.enrollment.courses[0].enrollment_status}}</td>
                    </tr>
                    <tr>
                        <td>Date Enrolled:</td>
                        <td>{{moment(this.enrollment.courses[0].created_at).format('DD-MM-YYYY')}},{{moment().format('DD-MM-YYYY')}}</td>
                    </tr>
                    <tr>
                        <td>Last Updated:</td>
                        <td>{{moment(this.enrollment.courses[0].updated_at).format('DD-MM-YYYY')}}</td>
                    </tr>
                    <tr>
                        <td><strong>Course Details</strong></td>
                    </tr>
                    <tr>
                        <td>Title:</td>
                        <td>{{this.enrollment.courses[0].course_number}} - {{this.enrollment.courses[0].descriptive_title}}</td>
                    </tr>
                    <tr>
                        <td>Level:</td>
                        <td>{{this.enrollment.courses[0].course_level}}</td>
                    </tr>

                    <tr>
                        <td>Status:</td>
                        <td>{{this.enrollment.courses[0].course_status}}</td>
                    </tr>
                    <tr>
                        <td>Grade:</td>
                        <td v-if='this.enrollment.student[0].grade'>{{this.enrollment.student[0].grade}}</td>
                        <td v-else>N/A</td>
                    </tr>
                </tbody>
            </table>

            <!-- <h6><strong># Comments</strong></h6>
            <table class="table table-sm">
                <thead>
                <tr>
                    <td>
                        <form action="#" method="POST">
                            <div class="form-group">
                                <textarea class="form-control" name="comment" id="comment" rows="2" placeholder="Comment Here">#</textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-dark align-content-center">Add Comment</button>
                            </div>
                        </form>
                    </td>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>#</strong>
                            <small>#</small>
                        
                                <span onclick="#"
                                    class="btn btn-danger btn-sm float-right">
                                    Delete
                                </span>
                                <form style="display: none" id="#" action="#">
                                </form>
                        </td>
                    </tr>
                    <tr>
                        <td>#</td>
                    </tr>
                </tbody>
            </table>
            -->
        </div>
        <!-- Update Enrollment Status-->
        <div class="modal fade" id="updateEnroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Enrollment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveEnrollmentStatus()">
                        <div v-if="enrollment.courses" class="modal-body">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="form-group">
                                        <label for="e-enrollment_status">Enrollment Status</label>
                                        <select class="custom-select my-1 mr-sm-2" id="e-enrollment_status" v-model="form.enrollment_status" name="enrollment_status">
                                            <option value="0" selected="selected" class="form-control">Enrolled</option>
                                            <option value="1" class="form-control">Incomplete</option>
                                            <option value="2" class="form-control">Dropped</option>
                                            <option value="3" class="form-control">Withdrawn</option>
                                            <option value="4" class="form-control">Completed</option>
                                        </select>
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
        <!-- Update Course Status -->
        <div class="modal fade" id="updateCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Enrollment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveCourseStatus()">
                        <div v-if="enrollment.courses" class="modal-body">
                            <div class="form-group">
                                <div class="form-check">
                                    <div class="form-group">
                                        <label for="e-course_status">Enrollment Status</label>
                                        <select class="custom-select my-1 mr-sm-2" id="e-course_status" v-model="form.course_status" name="course_status">
                                            <option value="0" selected="selected" class="form-control">Failed</option>
                                            <option value="1" class="form-control">In Progress</option>
                                            <option value="2" class="form-control">Passed</option>
                                        </select>
                                        <label for="c-grade">Grade</label>
                                        <input id="c-grade" v-model="form.grade" type="text" name="c-grade"
                                            placeholder="Grade..."
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-grade') }">
                                            <has-error :form="form" field="c-grade"></has-error>
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
    props: [
        'data_id'
    ],
    data(){
        return{
            enrollment: {},
            moment: moment,
            course_status: '',
            checker: '',
            residency_time: '',
            form: new Form({
                course_status: '',
                enrollment_status: '',
                grade: ''
            })
        }
    },
    methods:{
        getenrollments(){
            axios.post('../api/trackEnrollment/'+this.data_id)
            .then(response=>{
                this.enrollment = response.data
                let course_stat = response.data.courses[0].course_status;
                let enrollment_stat = response.data.courses[0].enrollment_status;
                this.form.grade = response.data.student[0].grade;
                if(course_stat == 'Passed') this.form.course_status = '2'
                if(course_stat == 'In Progress') this.form.course_status = '1'
                if(course_stat == 'Failed') this.form.course_status = '0'
                if(enrollment_stat == 'Enrolled') this.form.enrollment_status = '0', this.checker = '1';
                if(enrollment_stat == 'Incomplete') this.form.enrollment_status = '1', this.checker = '1';
                if(enrollment_stat == 'Dropped') this.form.enrollment_status = '2', this.checker = '0';
                if(enrollment_stat == 'Withdrawn') this.form.enrollment_status = '3', this.checker = '0';
                if(enrollment_stat == 'Completed') this.form.enrollment_status = '4', this.checker = '0';
            });
        },
        newTracking(){
            axios.post('../api/newTracking/'+this.data_id)
            .then(response=>{
                window.location = "/enrollmentTrack/"+this.data_id;
            })
        },
        updateEnrollment(){
            let getStatus = this.getStatus;
            if(getStatus==1){
               $('#updateCourse').modal('show');
            }else if(getStatus==0){
               $('#updateEnroll').modal('show');
            }
        },
        saveCourseStatus(){
            this.form.post('../api/saveCourseStatus/'+this.data_id)
            .then(response=>{
                $('#updateCourse').modal('hide');
                this.getenrollments();
                this.getEnrollmentStatus();
            })
        },
        saveEnrollmentStatus(){
            this.form.post('../api/saveEnrollmentStatus/'+this.data_id)
            .then(response=>{
                $('#updateEnroll').modal('hide');
                this.$router.go()
            })
        },
        getEnrollmentStatus(){
            let x = [2,3,4];
            let status = this.form.enrollment_status;
            for(let i = 0; i<x.length; i++){
                if(x[i]==this.form.enrollment_status){
                    this.checker = 1;
                }
                
            }
            this.checker = 0;
        }
    },
    computed: {
        getStatus(){
            let status = this.enrollment.courses[0].enrollment_status;
            if(status=='Completed'){
                return 1;
            }else{
                return 0;
            }
        },
        residency(){
            let x = moment();
            let y = this.enrollment.courses[0].created_at;
            return x.diff(y, 'days');
        }
    },
    created(){
        this.getenrollments();
        this.getEnrollmentStatus();
    }
}
</script>