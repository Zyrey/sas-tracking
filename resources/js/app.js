require("./bootstrap");

window.Vue = require("vue");
window.VueRouter=require('vue-router').default;

import Vuetify from "vuetify";
import DatetimePicker from "vuetify-datetime-picker";
import Swal from "sweetalert2";
import VueProgressBar from 'vue-progressbar';
import BootstrapVue from 'bootstrap-vue';
import VueRouter from "vue-router";
import { Form, HasError, AlertError } from 'vform'
import moment from 'moment';

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.use(BootstrapVue);
Vue.use(Vuetify);
Vue.use(DatetimePicker);
Vue.use(VueRouter);

window.Form = Form
window.moment = moment
// Sweetalert
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
window.Toast = Toast;

// Progress bar
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
});

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

//cluster component
Vue.component('clustercreate', require('./components/cluster/ClusterCreate.vue').default);
Vue.component('clusterform', require('./components/cluster/ClusterForm.vue').default);
Vue.component('clusteredit', require('./components/cluster/ClusterEdit.vue').default);
Vue.component('clustershow', require('./components/cluster/ClusterShow.vue').default);
Vue.component('clusterindex', require('./components/cluster/ClusterIndex.vue').default);

//course component
Vue.component('coursecreate', require('./components/course/CourseCreate.vue').default);
Vue.component('courseform', require('./components/course/CourseForm.vue').default);
Vue.component('courseedit', require('./components/course/CourseEdit.vue').default);
Vue.component('courseshow', require('./components/course/CourseShow.vue').default);
Vue.component('courseindex', require('./components/course/CourseIndex.vue').default);

//course level component
Vue.component('courslevelecreate', require('./components/courselevel/CourseLevelCreate.vue').default);
Vue.component('courselevelform', require('./components/courselevel/CourseLevelForm.vue').default);
Vue.component('courseleveledit', require('./components/courselevel/CourseLevelEdit.vue').default);
Vue.component('courselevelshow', require('./components/courselevel/CourseLevelShow.vue').default);
Vue.component('courselevelindex', require('./components/courselevel/CourseLevelIndex.vue').default);

//enrolled student component
Vue.component('enrolledstudent', require('./components/enrolled-student/Enrollled_Student.vue').default);

//enrollment componet
Vue.component('enrollmentcreate', require('./components/enrollment/EnrollmentCreate.vue').default);
Vue.component('enrollmentlform', require('./components/enrollment/EnrollmentForm.vue').default);
Vue.component('enrollmentindex', require('./components/enrollment/EnrollmentIndex.vue').default);
Vue.component('enrollmenttrack', require('./components/enrollment/EnrollmentTrack.vue').default);
Vue.component('enrollmenttrack2', require('./components/enrollment/EnrollmentTrackList.vue').default);
Vue.component('viewtrackstep', require('./components/enrollment/EnrollmentTrackStepView.vue').default);

//faculty component
Vue.component('facultycreate', require('./components/faculty/FacultyCreate.vue').default);
Vue.component('facultyform', require('./components/faculty/FacultyForm.vue').default);
Vue.component('facultyedit', require('./components/faculty/FacultyEdit.vue').default);
Vue.component('facultyshow', require('./components/faculty/FacultyShow.vue').default);
Vue.component('facultyindex', require('./components/faculty/FacultyIndex.vue').default);

//institution component
Vue.component('institutioncreate', require('./components/institution/InstitutionCreate.vue').default);
Vue.component('institutionform', require('./components/institution/InstitutionForm.vue').default);
Vue.component('institutionedit', require('./components/institution/InstitutionEdit.vue').default);
Vue.component('institutionshow', require('./components/institution/InstitutionShow.vue').default);
Vue.component('institutionindex', require('./components/institution/InstitutionIndex.vue').default);

//password component
Vue.component('passwordchange', require('./components/password/PasswordChange.vue').default);

//profile component
Vue.component('profilecreate', require('./components/profile/ProfileCreate.vue').default);
Vue.component('profileform', require('./components/profile/ProfileForm.vue').default);
Vue.component('profileedit', require('./components/profile/ProfileEdit.vue').default);
Vue.component('profileshow', require('./components/profile/ProfileShow.vue').default);
Vue.component('profileindex', require('./components/profile/ProfileIndex.vue').default);

//program component
Vue.component('programcreate', require('./components/program/ProgramCreate.vue').default);
Vue.component('programform', require('./components/program/ProgramForm.vue').default);
Vue.component('programedit', require('./components/program/ProgramEdit.vue').default);
Vue.component('programshow', require('./components/program/ProgramShow.vue').default);
Vue.component('programindex', require('./components/program/ProgramIndex.vue').default);

//residency period component
Vue.component('residencyperiod', require('./components/residencyperiod/ResidencyPeriod.vue').default);

//role component
Vue.component('rolecreate', require('./components/role/RoleCreate.vue').default);
Vue.component('roleform', require('./components/role/RoleForm.vue').default);
Vue.component('roleedit', require('./components/role/RoleEdit.vue').default);
Vue.component('roleshow', require('./components/role/RoleShow.vue').default);
Vue.component('roleindex', require('./components/role/RoleIndex.vue').default);

//semester component
Vue.component('semestercreate', require('./components/semester/SemesterCreate.vue').default);
Vue.component('semesterform', require('./components/semester/SemesterForm.vue').default);
Vue.component('semesteredit', require('./components/semester/SemesterEdit.vue').default);
Vue.component('semestershow', require('./components/semester/SemesterShow.vue').default);
Vue.component('semesterindex', require('./components/semester/SemesterIndex.vue').default);

//step component
Vue.component('stepcreate', require('./components/step/StepCreate.vue').default);
Vue.component('stepform', require('./components/step/StepForm.vue').default);
Vue.component('stepedit', require('./components/step/StepEdit.vue').default);
Vue.component('stepshow', require('./components/step/StepShow.vue').default);
Vue.component('stepindex', require('./components/step/StepIndex.vue').default);

//default step component
Vue.component('Sdefaultcreate', require('./components/step-default/SdefaultCreate.vue').default);
Vue.component('Sdefaultform', require('./components/step-default/SdefaultForm.vue').default);
Vue.component('Sdefaultedit', require('./components/step-default/SdefaultEdit.vue').default);

//requirement step component
Vue.component('Srequirementcreate', require('./components/steprequirement/SrequirementCreate.vue').default);
Vue.component('Srequirementedit', require('./components/steprequirement/SrequirementEdit.vue').default);

//requirement step form component
Vue.component('adviser', require('./components/steprequirement/form/Adviser.vue').default);
Vue.component('file', require('./components/steprequirement/form/File.vue').default);
Vue.component('panelcreate', require('./components/steprequirement/form/PanelCreate.vue').default);
Vue.component('paneledit', require('./components/steprequirement/form/PanelEdit.vue').default);
Vue.component('result', require('./components/steprequirement/form/Result.vue').default);
Vue.component('schedule', require('./components/steprequirement/form/Schedule.vue').default);
Vue.component('topic', require('./components/steprequirement/form/Topic.vue').default);

//student component
Vue.component('studentcreate', require('./components/student/StudentCreate.vue').default);
Vue.component('studentform', require('./components/student/StudentForm.vue').default);
Vue.component('studentedit', require('./components/student/StudentEdit.vue').default);
Vue.component('studentshow', require('./components/student/StudentShow.vue').default);
Vue.component('studentindex', require('./components/student/StudentIndex.vue').default);
Vue.component('student', require('./components/student/Student.vue').default);

//student enrolled course
Vue.component('editenrollmentstatus', require('./components/studentenrolledcourse/EditEnrollmentStatus.vue').default);
Vue.component('SECform', require('./components/studentenrolledcourse/SECform.vue').default);
Vue.component('SECedit', require('./components/studentenrolledcourse/SECedit.vue').default);

//student enrollment
Vue.component('studenterollment', require('./components/studentenrollment/StudentEnrollmentIndex.vue').default);

//super admin component
Vue.component('superadminhome', require('./components/superadmin/SuperAdminHome.vue').default);
Vue.component('superadminshow', require('./components/superadmin/SuperAdminShow.vue').default);

//super admin auth component

//tracking component
Vue.component('trackingindex', require('./components/tracking/TrackingIndex.vue').default);
Vue.component('trackingshow', require('./components/tracking/TrackingShow.vue').default);

//tracking card component
Vue.component('enrolledcourse', require('./components/tracking/card/EnrolledCourse.vue').default);
Vue.component('tracking', require('./components/tracking/card/Tracking.vue').default);

//tracking step component
Vue.component('completed', require('./components/trackingStep/Completed.vue').default);
Vue.component('tscreate', require('./components/trackingStep/TScreate.vue').default);
Vue.component('tsform', require('./components/trackingStep/TSform.vue').default);
Vue.component('tsedit', require('./components/trackingStep/TSedit.vue').default);
Vue.component('tsshow', require('./components/trackingStep/TSshow.vue').default);

//tracking step requirement component
Vue.component('tsadviser', require('./components/trackingStep/requirement/TSadviser.vue').default);
Vue.component('tsdefault', require('./components/trackingStep/requirement/TSdefault.vue').default);
Vue.component('tsfile', require('./components/trackingStep/requirement/TSfile.vue').default);
Vue.component('tspanel', require('./components/trackingStep/requirement/TSpanel.vue').default);
Vue.component('tsresult', require('./components/trackingStep/requirement/TSresult.vue').default);
Vue.component('tsschedule', require('./components/trackingStep/requirement/TSschedule.vue').default);
Vue.component('tstopic', require('./components/trackingStep/requirement/TStopic.vue').default);

//user component
Vue.component('userform', require('./components/user/Userform.vue').default);
Vue.component('useredit', require('./components/user/Useredit.vue').default);
Vue.component('usershow', require('./components/user/Usershow.vue').default);

//user: admin component
Vue.component('admincreate', require('./components/user/admin/AdminCreate.vue').default);
Vue.component('adminhome', require('./components/user/admin/AdminHome.vue').default);
Vue.component('adminindex', require('./components/user/admin/AdminIndex.vue').default);

//user: coordinator component
Vue.component('coordinatorcreate', require('./components/user/coordinator/CoordinatorCreate.vue').default);
Vue.component('cooerdinatorhome', require('./components/user/coordinator/CoordinatorHome.vue').default);
Vue.component('coordinatorindex', require('./components/user/coordinator/CoordinatorIndex.vue').default);


//router links
export const routes = [
    {
        path: '/student/id/enrollments',
        name: 'StudentEnrollment',
        component: () => import('./components/studentenrollment/StudentEnrollmentIndex.vue')
    }
];

Vue.component("calendar", require("./components/Calendar.vue").default);

const app = new Vue({
    el: "#app",
    router,
    vuetify: new Vuetify()
});
