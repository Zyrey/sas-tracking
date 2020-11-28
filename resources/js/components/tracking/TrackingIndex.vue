<template>
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <a href="" class="btn btn-sm btn-dark">Back</a>
            </div>

            <div class="">
                <tracking-enrolled-course></tracking-enrolled-course>
            </div>


            <div class="col-md-7">
                <tracking></tracking>
            </div>
        </div>
    </div>
</template>
<script>
import TrackingEnrolledCourse  from './card/EnrolledCourse.vue'
import Tracking  from './card/Tracking.vue'
export default {
    components:{
        TrackingEnrolledCourse,
        Tracking
    }
}
</script>
