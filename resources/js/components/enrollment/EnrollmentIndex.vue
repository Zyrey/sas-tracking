<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>List of Enrollments for  (Current Semester)</h4>
                        <div>
                            <button @click="enroll()" class="btn btn-sm btn-dark mb-2">Create New Enrollment</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Semester</th>
                                    <th>Program</th>
                                    <th>Residency Period</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="enrollments in enrollment" v-bind:key="enrollments.id">
                                        <td>
                                            {{enrollments.id_number}}<a href=""></a>
                                        </td>
                                        <td>{{enrollments.last_name}}, {{enrollments.first_name}} {{enrollments.middle_name}}.</td>
                                        <td>{{enrollments.year_start}}-{{enrollments.year_end}} Term: {{enrollments.term}}</td>
                                        <td>{{enrollments.program}}</td>
                                        <td>{{getResidency(enrollments.month_start,enrollments.year_start2)}} Months</td>
                                        <td>
                                            <button @click="viewEnroll(enrollments.enrollment_id)" class="btn btn-sm btn-primary mb-2">View</button>
                                            <button @click="addNewCourse(enrollments)" class="btn btn-sm btn-primary mb-2">Add Course</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <button @click="showUpdateSem()" class="btn btn-success btn-sm">Update Semester</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Create Course Modal -->
        <div class="modal fade" id="enroll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enroll Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createEnroll()">
                        <div class="modal-body">
                            <div><font color="red">{{this.message}}</font></div>
                            <div class="form-group">
                                <label for="c-student">Student ID Number</label>
                                <input id="c-student" @change="checkId()" v-model="form.student" type="text" name="c-student"
                                    placeholder="Student ID Number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-student') }" required>
                                    <has-error :form="form" field="c-student"></has-error>
                            </div>
                            <div v-if="id_data.length" class="form-group">
                                <div v-for="data in id_data" v-bind:key="data.id">
                                    <label for="c-fname">Firstname</label>
                                    <input id="c-fname" type="text" name="c-fname"
                                    v-bind:value="data.first_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-fname') }" readonly>
                                    <has-error :form="form" field="c-fname"></has-error>
                                </div>
                                <div v-for="data in id_data" v-bind:key="data.id">
                                    <label for="c-lname">Lastname</label>
                                    <input id="c-lname" type="text"
                                    v-bind:value="data.last_name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-lname') }" readonly>
                                    <has-error :form="form" field="c-lname"></has-error>
                                </div>
                                <div v-for="data in id_data" v-bind:key="data.id">
                                    <label for="c-mname">Middlename</label>
                                    <input id="c-mname" type="text"
                                        v-bind:value="data.middle_name"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-mname') }" readonly>
                                        <has-error :form="form" field="c-mname"></has-error>
                                </div>
                                <div v-for="data in id_data" v-bind:key="data.id">
                                    <label for="c-email">Email</label>
                                    <input id="c-email" type="text"
                                        v-bind:value="data.email"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-email') }" readonly>
                                        <has-error :form="form" field="c-email"></has-error>
                                </div>
                                <div v-for="data in id_data" v-bind:key="data.id">
                                    <label for="c-contact">Contact</label>
                                    <input id="c-contact" type="text"
                                        v-bind:value="data.contact_number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-contact') }" readonly>
                                        <has-error :form="form" field="c-contact"></has-error>
                                </div>
                            </div>
                            <div v-else class="form-group">
                                <div>
                                    <label for="c-fname">Firstname</label>
                                    <input id="c-fname" type="text" name="c-fname"
                                    v-model="form.fname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-fname') }" required>
                                    <has-error :form="form" field="c-fname"></has-error>
                                </div>
                                <div>
                                    <label for="c-lname">Lastname</label>
                                    <input id="c-lname" type="text"
                                    v-model="form.lname"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-lname') }" required>
                                    <has-error :form="form" field="c-lname"></has-error>
                                </div>
                                <div>
                                    <label for="c-mname">Middlename</label>
                                    <input id="c-mname" type="text"
                                        v-model="form.mname"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-mname') }" required>
                                        <has-error :form="form" field="c-mname"></has-error>
                                </div>
                                <div>
                                    <label for="c-email">Email</label>
                                    <input id="c-email" type="text"
                                        v-model="form.email"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-email') }" required>
                                        <has-error :form="form" field="c-email"></has-error>
                                </div>
                                <div>
                                    <label for="c-contact">Contact</label>
                                    <input id="c-contact" type="text"
                                        v-model="form.contact"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-contact') }" required>
                                        <has-error :form="form" field="c-contact"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-sem">Semester</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-sem" v-model="form.semester" name="c-sem" required>
                                    <option selected value="">Select Program...</option>
                                    <option v-for="sem in semesters" v-bind:key="sem.id" v-bind:value="sem.id"> 
                                        {{sem.term}}({{sem.year_start}}-{{sem.year_end}})
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="c-program">Program</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-program" @change="getCourse($event)" v-model="form.program" name="c-program" required>
                                    <option selected value="">Select Program...</option>
                                    <option v-for="prog in programs" v-bind:key="prog.id" v-bind:value="prog.id"> 
                                        {{prog.program}}
                                    </option>
                                </select>
                                <has-error :form="form" field="c-program"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-course">Course(s)</label>
                                <span v-for="cour in course" v-bind:key="cour.id" v-bind:value="cour.id" >
                                    <div class="form-check">
                                        <input type="checkbox" v-bind:value="cour.id" v-model="form.course"> 
                                        <span class="checkbox-label"> {{cour.course_number}}, {{cour.id}} </span> <br>
                                    </div>
                                </span>
                                <hr>
                                <has-error :form="form" field="c-course"></has-error>
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
        <!-- View Course Modal -->
        <div class="modal fade" id="viewEnrolledCourses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ID Number - Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table border">
                                    <thead>
                                        <tr>
                                            <th>Course</th> 
                                            <th>Level</th> 
                                            <th>Status</th> 
                                            <th>Enrollment Status</th> 
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="ec in e_courses" v-bind:key="ec.id">
                                            <td>{{ec.course_number}} - {{ec.descriptive_title}}</td> 
                                            <td>{{ec.course_level}}</td> 
                                            <td>{{ec.course_status}}</td> 
                                            <td>{{ec.enrollment_status}}</td> 
                                            <td class="d-flex">
                                                <span>
                                                    <a v-bind:href="'/enrollmentTrack/'+ec.id" class="btn btn-primary btn-sm">Course Details</a>
                                                    <button @click="deleteCourse(ec.id)" class="btn btn-danger btn-sm">Delete</button>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Course -->
        <div class="modal fade" id="addCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enroll Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createEnroll()">
                        <div class="modal-body">
                            <div><font color="red">{{this.message}}</font></div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="c-student">Student ID Number</label>
                                        <input id="c-student" v-model="form.id_number" type="text" name="c-student"
                                        placeholder="Student ID Number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-student') }" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="c-student">Program</label>
                                        <input id="c-student" v-model="form.program" type="text" name="c-student"
                                        placeholder="Student ID Number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-student') }" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label for="c-fname">Firstname</label>
                                        <input id="c-fname" v-model="form.first_name" type="text" name="c-fname"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-fname') }" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="c-fname">Lastname</label>
                                        <input id="c-fname" v-model="form.last_name" type="text" name="c-fname"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-fname') }" readonly>
                                    </div>
                                    <div class="col">
                                        <label for="c-fname">Middlename</label>
                                        <input id="c-fname" v-model="form.middle_name" type="text" name="c-fname"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-fname') }" readonly>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="c-student">Year Start</label>
                                            <input id="c-student" v-model="form.year_start" type="text" name="c-student"
                                            placeholder="Student ID Number"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-student') }" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="c-student">Year End</label>
                                            <input id="c-student" v-model="form.year_end" type="text" name="c-student"
                                            placeholder="Student ID Number"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-student') }" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="c-student">Term</label>
                                            <input id="c-student" v-model="form.term" type="text" name="c-student"
                                            placeholder="Student ID Number"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('c-student') }" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <has-error :form="form" field="c-course"></has-error>
                                <ul class="list-group">
                                    <li class="list-group-item active">Enrolled Course(s)</li>
                                    <li v-for="cour in e_courses" v-bind:key="cour.id" class="list-group-item">{{cour.course_number}}-{{cour.descriptive_title}}</li>
                                </ul>
                            </div>
                            <div class="form-group">
                                <label for="c-course">Available Course(s)</label>
                                <span>
                                    <div class="form-check" v-for="cour in course" v-bind:key="cour.id">
                                        <input v-model="form.course" type="checkbox" v-bind:value="cour.id">
                                        <span class="checkbox-label">{{cour.course_number}}-{{cour.descriptive_title}}</span><br>
                                    </div>
                                </span>
                                <hr>
                                <has-error :form="form" field="c-course"></has-error>
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
        <!-- Update Semester Modal -->
        <div class="modal fade" id="updateSemester" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Semester</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveUpdateSem()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="c-program">Semester</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-program" v-model="form.updatesem" name="c-program" required>
                                    <option selected value="">Select Semester...</option>
                                    <option v-for="sem in semesters" v-bind:key="sem.id" v-bind:value="sem.id" :disabled="sem.current=='1'"> 
                                        {{sem.year_start}}-{{sem.year_end}} ({{sem.term}})<template v-if="sem.current=='1'"> (Current)</template>
                                    </option>
                                </select>
                                <has-error :form="form" field="c-program"></has-error>
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
            enrollment: {},
            programs: {},
            course: {},
            courseLevel: {},
            id_data: {},
            semesters: {},
            e_courses: {},
            e_courses2: [],
            choices: {},
            message: '',
            moment: moment,
            form: new Form({
                student: '',
                fname: '',
                lname: '',
                mname: '',
                email: '',
                contact: '',
                semester:'',
                program:'',
                course:[],
                courseLevel: '',
                enrolled:'',
                semester:'',
                id_number:'',
                first_name: '',
                last_name: '',
                middle_name: '',
                year_end: '',
                year_start: '',
                term: '',
                updatesem: ''
            })
        }
    },
    methods:{
        getenrollments(){
            axios.get('api/enrolledstudent')
            .then(response => this.enrollment = response.data);
        },
        checkE(e){
            console.log(e);
        },
        enroll(){
            this.form.reset();
            $('#enroll').modal('show');
        },
        getPrograms(){
            axios.get('api/programlist')
            .then(response => this.programs = response.data);
        },
        getCourse(event){
            this.form.course = [];
            axios.post('api/sCourse/'+event.target.value)
            .then(response => this.course = response.data);
        },
        getCourseLevel(){
            axios.get('api/courseLevel')
            .then(response => this.courseLevel = response.data);
        },
        getSemesters(){
            axios.get('api/semesters')
            .then(response => this.semesters = response.data);
        },
        createEnroll(){
           this.form.post('api/newEnroll')
           .then(response => {
               $('#enroll').modal('hide');
               this.getenrollments();
               this.message = response.data;
           }).catch(error =>{
               console.log('response');
           })
        },
        checkId(){
            this.id_data = {};
            this.form.clear();
            axios.post('api/checkId/'+this.form.student)
            .then(response => this.id_data = response.data);
        },
        viewEnroll(e_id){
            axios.post('api/getEnrolledCourses/'+e_id)
            .then(response => this.e_courses = response.data);
            $('#viewEnrolledCourses').modal('show');
        },
        deleteCourse(c_id){
            axios.post('api/deleteEnrolledCourse/'+c_id)
            .then(response =>{
            $('#viewEnrolledCourses').modal('hide');
            this.getenrollments();
            });
        },
        addNewCourse(data){
            this.form.fill(data);
            this.form.course = [];
            let enrolled = [];
            axios.post('api/sCourse/'+data.program_id)
            .then(response => {
                this.course = response.data;
            });
            axios.post('api/getEnrolledCourses/'+data.enrollment_id)
            .then(response2 => {
                this.e_courses = response2.data;
                enrolled = response2.data
            });
            $('#addCourse').modal('show');
        },
        showUpdateSem(){
            $('#updateSemester').modal('show');
        },
        saveUpdateSem(){
            this.form.post('api/updateSem')
            .then(response=>{
                $('#updateSemester').modal('hide');
                this.getenrollments();
                this.getSemesters();
                this.getPrograms();
                this.getCourseLevel();
            })
        },
        getResidency(x,yy){
            let create_date = new Date(yy,x);
            let today = moment();
            return today.diff(create_date,'months');
        }
    },
    created(){
        this.getenrollments();
        this.getPrograms();
        this.getCourseLevel();
        this.getSemesters();
    }
}
</script>