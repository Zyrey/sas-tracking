<template>
<div class="col-lg-24">
    <div v-for="(track, index) in trackings.trackList" v-bind:key="track.id" class="card">
        <div :class="changeBg(track.status)">
            <h4 v-if="track.status=='Active'">Tracking #{{track.id}} (Active)</h4>
            <h4 v-if="track.status=='Inactive'">Tracking #{{track.id}} (Inactive)</h4>
            
            <div>
                <button @click="newStep()" v-if="track.status=='Active' && enrollmentStatus==0" class="btn btn-sm btn-dark mb-2">Add New Step</button>
                <button @click="viewTrack(track.id)" class="btn btn-sm btn-dark mb-2">View</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <span class="badge" style="background-color:rgb(204, 232, 213)">Completed</span>
                        <span class="badge" style="background-color:rgb(163, 185, 230)">Active</span>
                        <span class="badge" style="background-color:rgb(165, 170, 181)">Inactive</span>
                        
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Take</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(step, stepIndex) in steps[index]" v-bind:key="step.id" :style="changeBg2(step.status,step.complete)">
                            <td>{{stepIndex+1}}</td>
                            <td>{{step.step_name}}</td>
                            <td>{{step.default}}</td>
                            <td>{{step.take_number}}</td>
                            <td>
                                <a v-bind:href="'/viewStep/'+step.id" class="btn btn-sm btn-primary mb-2">View</a>
                            </td>
                        </tr>
                        <!--<tr>
                            <td>No Enrollment to Show</td>
                        </tr>-->
                    </tbody>
                </table>
                <div>
                </div>
            </div>
        </div>
    </div>
    <!-- Create Step Modal -->
    <div class="modal fade" id="newStep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Step</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveStep()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="c-step">Step Name</label>
                            <input id="c-step" v-model="form.step" type="text" name="c-step"
                                placeholder="Step name..."
                                class="form-control" :class="{ 'is-invalid': form.errors.has('c-step') }" required>
                                <has-error :form="form" field="c-step"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="c-number">Step Number</label>
                            <input id="c-number" v-model="form.step_number" type="text" name="c-number"
                                placeholder="Step name..."
                                class="form-control" :class="{ 'is-invalid': form.errors.has('c-number') }" required>
                                <has-error :form="form" field="c-number"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="c-requirements">Requirements(optional)</label>
                            <div class="form-check">
                                <div class="form-check">
                                    <input id="c-requirements" v-model="form.requirements" name="c-requirements" class="form-check-input" :class="{ 'is-invalid': form.errors.has('c-requirements') }" type="radio" value="1">
                                    <has-error :form="form" field="c-requirements"></has-error>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Adviser
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="c-requirements" v-model="form.requirements" name="c-requirements" class="form-check-input" :class="{ 'is-invalid': form.errors.has('c-requirements') }" type="radio" value="2">
                                    <has-error :form="form" field="c-requirements"></has-error>
                                    <label class="form-check-label" for="defaultCheck1">
                                        File
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="c-requirements" v-model="form.requirements" name="c-requirements" class="form-check-input" :class="{ 'is-invalid': form.errors.has('c-requirements') }" type="radio" value="3">
                                    <has-error :form="form" field="c-requirements"></has-error>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Panel
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="c-requirements" v-model="form.requirements" name="c-requirements" class="form-check-input" :class="{ 'is-invalid': form.errors.has('c-requirements') }" type="radio" value="4">
                                    <has-error :form="form" field="c-requirements"></has-error>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Result (Pass / Revision / Fail)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="c-requirements" v-model="form.requirements" name="c-requirements" class="form-check-input" :class="{ 'is-invalid': form.errors.has('c-requirements') }" type="radio" value="5">
                                    <has-error :form="form" field="c-requirements"></has-error>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Schedule
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="c-requirements" v-model="form.requirements" name="c-requirements" class="form-check-input" :class="{ 'is-invalid': form.errors.has('c-requirements') }" type="radio" value="6">
                                    <has-error :form="form" field="c-requirements"></has-error>
                                    <label class="form-check-label" for="defaultCheck1">
                                        Topic
                                    </label>
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
    <!-- View Track Modal -->
    <div class="modal fade" id="viewTrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <template v-if="trackingsData.track_data">
                        <h5 class="modal-title" id="exampleModalLabel">Viewing Track #{{trackingsData.track_data[0].id}}</h5>
                        <div class="float-right" v-if="enrollmentStatus==0">
                            <button v-if="trackingsData.track_data[0].status=='Active'" @click="deactivateTrack(trackingsData.track_data[0].id)" class="btn btn-sm btn-danger">Deactivate</button>
                            <button v-else @click="activateTrack(trackingsData.track_data[0].id)" class="btn btn-sm btn-dark">Activate</button>
                        </div>
                    </template>
                </div>
                <div class="col-md-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <table class="table-responsive-lg table-borderless">
                                <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody v-if="trackingsData.track_data">
                                    <tr>
                                        <th>Tracking Details</th>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td><b>{{trackingsData.track_data[0].status}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Completion Status:</td>
                                        <td><b>{{percentageCompletion}}%</b></td>
                                    </tr>
                                    <tr>
                                        <td>Date Created:</td>
                                        <td><b>{{moment(trackingsData.track_data[0].created_at).format('DD-MM-YYYY')}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Last Update:</td>
                                        <td><b>{{moment(trackingsData.track_data[0].updated_at).format('DD-MM-YYYY')}}</b></td>
                                    </tr>
                                    <tr>
                                        <th>Number of Active Steps</th>
                                    </tr>
                                    <tr>
                                        <td>Total:</td>
                                        <td><b>{{trackingsData.track_steps.length}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Completed:</td>
                                        <td><b>{{completedTotal}}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Incomplete:</td>
                                        <td><b>{{incompleteTotal}}</b></td>
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
</div>
</template>
<script>
export default {
    props: [
        'data_id'
    ],
    data(){
        return{
            trackings: [],
            moment: moment,
            stepsIds: [],
            steps: [],
            trackingsData: [],
            enrollmentStatus: '',
            moment:moment,
            form: new Form({
                step: '',
                step_number: '',
                requirements: []
            })
        }
    },
    methods:{
        changeBg(x){
            if(x=='Inactive'){
                return "card-header bg-danger";
            }else{
                return "card-header bg-primary";
            }
        },
        changeBg2(x,y){
            if(x=='Inactive' && y=='Incomplete'){
                return "background-color:rgb(165, 170, 181)";
            }else if(x=='Active' && y=='Incomplete'){
                return "background-color:rgb(163, 185, 230)";
            }
            if(y=='Completed'){
                return "background-color:rgb(204, 232, 213)";
            }
        },
        viewTrack(id){
            axios.post('../api/getTrackData/'+id)
            .then(response=>{
                this.trackingsData = response.data;
            })
            $('#viewTrack').modal('show');
        },
        getTrackings(){
            let tracks = 0;
            axios.post('../api/getTrack/'+this.data_id)
            .then(response=>{
                this.trackings = response.data;
                tracks = response.data.trackList;
                for(let i = 0; i<tracks.length; i++){
                    axios.post('../api/getStepsPerTrack/'+tracks[i].id)
                    .then(response2=>{
                        this.steps.push(response2.data);
                    });
                }
            });
        },
        getEnrollmentStatus(){
            axios.post('../api/enrollmentStatus/'+this.data_id)
            .then(response=>{
                this.enrollmentStatus = response.data;
            });
        },
        saveStep(){
            this.form.post('../api/saveNewStep/'+this.data_id)
            .then(()=>{
                $('#newStep').modal('hide');
                window.location = "/enrollmentTrack/"+this.data_id;
            }).catch(()=>{

            });
        },
        newStep(){
            $('#newStep').modal('show');
        },
        deactivateTrack(id){
            axios.post('../api/deactivateTrack/'+id)
            .then(response=>{
                $('#viewTrack').modal('hide');
                this.getTrackings();
            });
        },
        activateTrack(id){
            axios.post('../api/activateTrack/'+id)
            .then(response=>{
                $('#viewTrack').modal('hide');
                window.location = "/enrollmentTrack/"+this.data_id;
            });
        },
        editStep(id){
            console.log(id);
        }
    },
    computed: {
        completedTotal(){
            let completed = 0;
            let tracks = this.trackingsData.track_steps;
            for(let i = 0; i < tracks.length; i++){
                if(tracks[i].complete=='Completed'){
                    completed = completed+1;
                }
            }
            return completed;
        },
        incompleteTotal(){
            let incomplete = 0;
            let tracks = this.trackingsData.track_steps;
            for(let i = 0; i < tracks.length; i++){
                if(tracks[i].complete=='Incomplete'){
                    incomplete = incomplete+1;
                }
            }
            return incomplete;
        },
        percentageCompletion(){
            let tracks = this.trackingsData.track_steps;
            let percentage = this.completedTotal/tracks.length*100;
            return percentage.toFixed(2);
        }
    },
    created(){
        this.getTrackings();
        this.getEnrollmentStatus();
    }
}
</script>