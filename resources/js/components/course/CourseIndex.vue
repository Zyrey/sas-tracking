<template>
     <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>List of Courses</h4>
                        <div>
                            <button @click="createCourse()" class="btn btn-sm btn-dark mb-2">Create New Course</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course Number</th>
                                    <th>Descriptive Title</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="courses in course" v-bind:key="courses.id">
                                            <td>{{courses.id}}</td>
                                            <td>{{courses.course_number}}</td>
                                            <td>{{courses.descriptive_title}}</td>
                                            <td>
                                                <button @click="viewCourse(courses)" class="btn btn-sm btn-primary">View</button>
                                                <button @click="editCourse(courses)" class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                    <tr>
                                        <td>No Courses to Show</td>
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
        <!-- View Course Modal -->
        <div class="modal fade" id="viewCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Course</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="v-course_id">Course Id</label>
                            <input id="v-course_id" v-model="form.id" type="text" name="course_id"
                                placeholder="Course ID"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('course_id') }" readonly>
                        </div>
                        <div class="form-group">
                            <label for="v-course_number">Course Number</label>
                            <input id="v-course_number" v-model="form.course_number" type="text" name="course_number"
                                placeholder="Course Number"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('course_number') }" readonly>
                        </div>
                        <div class="form-group">
                            <label for="v-descriptive_title">Descriptive Title</label>
                            <input id="v-descriptive_title" v-model="form.descriptive_title" type="text" name="descriptive_title"
                                placeholder="Course Number"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('descriptive_title') }" readonly>
                        </div>
                        <div class="form-group">
                            <label for="v-program">Program</label>
                            <input id="v-program" v-model="form.program.program" type="text" name="program"
                                placeholder="Cluster"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('program') }" readonly>
                        </div>
                        <div class="form-group">
                            <label for="v-course_level">Level</label>
                            <input id="v-course_level" v-model="form.course_level.course_level" type="text" name="course_level"
                                placeholder="Level"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('course_level') }" readonly>
                        </div>
                        <div class="form-group">
                            <label for="v-course_units">Units</label>
                            <input id="v-course_units" v-model="form.units" type="text" name="course_units"
                                placeholder="Units"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('course_units') }" readonly>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Course Modal -->
        <div class="modal fade" id="editCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Course</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="updateCourse()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="e-course_id">Course Id</label>
                                <input id="e-course_id" v-model="form.id" type="text" name="course_id"
                                    placeholder="Course ID"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('course_id') }" readonly>
                            </div>
                            <div class="form-group">
                                <label for="e-course_number">Course Number</label>
                                <input id="e-course_number" v-model="form.course_number" type="text" name="course_number"
                                    placeholder="Course Number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('course_number') }">
                            </div>
                            <div class="form-group">
                                <label for="e-descriptive_title">Descriptive Title</label>
                                <input id="e-descriptive_title" v-model="form.descriptive_title" type="text" name="descriptive_title"
                                    placeholder="Course Number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('descriptive_title') }">
                            </div>
                            <div class="form-group">
                                <label for="e-program">Program</label>
                                <select class="custom-select my-1 mr-sm-2" id="e-program" v-model="form.program.id" name="program">
                                    <option selected>Select Program...</option>
                                    <option v-for="prog in programs" v-bind:key="prog.id" v-bind:value="prog.id"> 
                                        {{prog.program}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="e-course_level">Level</label>
                                <select class="custom-select my-1 mr-sm-2" id="e-course_level" v-model="form.course_level.id" name="course_level">
                                    <option selected>Choose Cluster...</option>
                                    <option v-for="cLevel in courseLevel" v-bind:key="cLevel.id" v-bind:value="cLevel.id">
                                        {{cLevel.course_level}}
                                    </option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Create Course Modal -->
        <div class="modal fade" id="createCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Course</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createCourseF()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="course_number">Course Number</label>
                                <input id="course_number" v-model="form.course_number" type="text" name="course_number"
                                    placeholder="Course Number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('course_number') }" required>
                                    <has-error :form="form" field="course_number"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="descriptive_title">Descriptive Title</label>
                                <input id="descriptive_title" v-model="form.descriptive_title" type="text" name="descriptive_title"
                                    placeholder="Course Number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('descriptive_title') }" required> 
                                    <has-error :form="form" field="descriptive_title"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="program">Program</label>
                                <select class="custom-select my-1 mr-sm-2" id="program" v-model="form.program" name="program" required>
                                    <option selected>Select Program...</option>
                                    <option v-for="prog in programs" v-bind:key="prog.id" v-bind:value="prog.id"> 
                                        {{prog.program}}
                                    </option>
                                </select>
                                <has-error :form="form" field="program"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="course_level">Level</label>
                                <select class="custom-select my-1 mr-sm-2" id="course_level" v-model="form.course_level" name="course_level" required>
                                    <option selected>Choose Cluster...</option>
                                    <option v-for="cLevel in courseLevel" v-bind:key="cLevel.id" v-bind:value="cLevel.id">
                                        {{cLevel.course_level}}
                                    </option>
                                </select>
                                <has-error :form="form" field="course_level"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="units">Units</label>
                                <input id="units" v-model="form.units" type="number" name="units" onkeypress="return event.charCode > 48" min="1"
                                    placeholder="Units"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('units') }" required>
                                    <has-error :form="form" field="units"></has-error>
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
            course: {},
            programs: {},
            courseLevel: {},
            form: new Form({
                id: '',
                course_number: '',
                descriptive_title: '',
                program: '',
                course_level: '',
                units: ''
            })
        }
    },
    methods:{
        viewCourse(courses){
            this.form.reset();
            $('#viewCourse').modal('show');
            this.form.fill(courses);
        },  
        editCourse(courses){
            this.form.reset();
            $('#editCourse').modal('show');
            this.form.fill(courses);
        },
        createCourse(){
            this.form.reset();
            $('#createCourse').modal('show');
        },
        getCourse(){
            axios.get('api/courselist')
            .then(response => this.course = response.data);
        },
        getPrograms(){
            axios.get('api/programlist')
            .then(response => this.programs = response.data);
        },
        getCourseLevel(){
            axios.get('api/courseLevel')
            .then(response => this.courseLevel = response.data);
        },
        updateCourse(){
            this.form.post('api/updateCourse/'+this.form.id)
            .then(() => {
                $('#editCourse').modal('hide');
                this.getCourse();
            }).catch(() => {
                console.log("Failed");
            })
        },
        createCourseF(){
            this.form.post('api/createCourse')
            .then(()=> {
                $('#createCourse').modal('hide');
                this.getCourse();
            }).catch(() => {
                console.log("Failed");
            })
        }
    },
    created(){
        this.getCourse();
        this.getPrograms();
        this.getCourseLevel();
    }
}
</script>