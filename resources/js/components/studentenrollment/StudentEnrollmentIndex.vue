<template>
    <div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <a :href="'/enrolledstudent'" class="btn btn-sm btn-dark">Back</a>
        </div>

        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-header bg-primary d-flex justify-content-between">
                    <h4>
                        <a href="" class="text-dark">{{idnumber.last_name}}, {{idnumber.first_name}} {{idnumber.middle_name}}</a>
                    </h4>
                    <h4>Enrollments for {{semester.year_start}}-{{semester.year_end}}</h4>
                </div>

                <div class="card-body">
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
                                    <tbody v-for="ec in enrolledcourse">
                                            <tr v-for="coursetaken in ec.enrolled_courses">
                                                <!-- <td>{{enrollmentcourse[0].enrolled_courses[0].course.course_number}} - {{enrollmentcourse[0].enrolled_courses[0].course.descriptive_title}}</td>
                                                    <td>{{enrollmentcourse[0].enrolled_courses[0].course.course_level.course_level}}</td>
                                                    <td>{{enrollmentcourse[0].enrolled_courses[0].course_status}}</td>
                                                    <td>{{enrollmentcourse[0].enrolled_courses[0].enrollment_status}}</td> -->
                                                    <td>{{coursetaken.course.course_number}} - {{coursetaken.course.descriptive_title}}</td>
                                                    <td>{{coursetaken.course.course_level.course_level}}</td>
                                                    <td>{{coursetaken.course_status}}</td>
                                                    <td>{{coursetaken.enrollment_status}}</td>
                                                    <td class="d-flex">
                                                    <span>
                                                        <a :href="'/students/'+student.id_number+'/enrollments/'+ec.id+'/enrolled-courses/'+coursetaken.course.id+'/trackings'" class="btn btn-primary btn-sm">Course Details</a>
                                                        <!-- <a href="" class="btn btn-primary btn-sm">Course Details</a> -->
                                                    </span>
                                                    </td>
                                            </tr>
                                        <p>No course enrolled in this current semester</p>
                                    </tbody>
                                </table>
                            </div>
                </div>
            </div>
                <div class="card">
                    <div class="card-header">
                        <h4>No Current Semester</h4>
                        <a href="" class="btn btn-success btn-sm">Update Semester</a>
                    </div>
                </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    props:['idnumber', 'enrollments', 'semester'],
    data(){
        return{
            enrolledcourse:[],
            course:[],
            student:[],
        }
    },
    methods:{
        getenrollecourse(){
            return this.enrolledcourse = this.enrollments;
        },
        getstudent(){
            return this.student = this.idnumber;
        }
        
    },
    mounted(){
        this.getenrollecourse();
        this.getstudent();
    }
}
</script>

