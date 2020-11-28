<template>
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <a  v-if="steps.step_data" v-bind:href="'/enrollmentTrack/'+steps.track_status[0].enrolled_course_id" class="btn btn-sm btn-dark">Back</a>
            </div>

            <div class="col-md-6">

                <div class="card mb-2">
                    <div v-if="steps.step_data" class="card-header d-flex justify-content-between bg-primary">
                        <h4>Step #{{steps.step_data[0].step_number}} (Take: {{steps.step_data[0].take_number}})
                        </h4>
                        <div class="d-flex">
                            <template v-if="steps.step_data && steps.track_status[0].status=='Active' && enrollmentStatus==0">
                                <div v-if="steps.step_data[0].complete=='Incomplete' && steps.step_data[0].status=='Active'">
                                    <button @click="editStep()" class="btn btn-sm btn-dark">Edit</button>
                                    <button @click="deleteStep(steps.step_data[0].id)" class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div v-if="steps.step_data" class="card-body">
                        <div v-if="steps.track_status[0].status=='Active'" class="d-flex justify-content-between">
                            <div v-if="steps.step_data && steps.step_data[0].status=='Active' && enrollmentStatus==0"> 
                                <button v-if="steps.step_data[0].complete=='Incomplete'" @click="completeStep(steps.step_data[0].id)" class="btn btn-sm btn-dark">Mark as Complete</button>
                                <button v-if="steps.step_data[0].complete=='Completed'" @click="incompleteStep(steps.step_data[0].id)" class="btn btn-sm btn-danger">Mark as Incomplete</button>
                            </div>
                            <div v-if="steps.step_data && steps.step_data[0].status=='Active' && enrollmentStatus==0"> 
                                <button class="btn btn-sm btn-dark" @click="duplicateStep(steps.step_data[0].id)">Duplicate Step</button>
                            </div>
                            <div v-if="steps.step_data && enrollmentStatus==0">
                                <button v-if="steps.step_data[0].status=='Active'" @click="deacStep(steps.step_data[0].id)" class="btn btn-sm btn-danger">Deactivate</button>
                                <button v-if="steps.step_data[0].status=='Inactive'" @click="activateStep(steps.step_data[0].id)" class="btn btn-sm btn-dark">Activate</button>
                            </div>
                        </div>

                        <table class="table table-sm table-borderless">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Step Details</th>
                            </tr>
                            <tr v-if="steps.step_data">
                                <td>Status: {{this.steps.step_data[0].status}}</td>
                                <td></td>
                            </tr>
                            <tr v-if="steps.step_data">
                                <td>Completion Status:{{this.steps.step_data[0].complete}}</td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr v-if="steps.step_data">
                                <td>No. of Takes:{{this.steps.step_data[0].take_number}}</td>
                                <td></td>
                            </tr>
                            <tr v-if="steps.step_data">
                                <td>Date Created: {{moment(this.steps.step_data[0].take_number).format('DD-MM-YYYY')}}</td>
                                <td></td>
                            </tr>
                            <tr v-if="steps.step_data">
                                <td>Last Updated: {{moment(this.steps.step_data[0].updated_at).format('DD-MM-YYYY')}}</td>
                                <td></td>
                            </tr>

                            <tr>
                                <th>History of Changes</th>
                            </tr>
                                <tr>
                                    <td>
                                        <a href="">
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <!-- <h6><strong>Comments</strong></h6>
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <td>
                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <textarea class="form-control" name="comment" id="comment" rows="2" placeholder="Comment Here"></textarea>
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
                                        <strong></strong>
                                        <small></small>
                                            <span onclick="" class="btn btn-danger btn-sm float-right">
                                                Delete
                                            </span>
                                            <form style="display: none" id="form-delete-enrolledCourseComment" action="" method="POST">
                                            </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table> -->

                    </div>
                </div>
            </div>


            <div v-if="steps.step_req" class="col-md-6">

                <div class="card mb-2">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>Requirement</h4>
                    </div>
                    <div class="card-body" v-if="!form.requirements_data.length>0 && !form.requirements_topic.length>0 && !form.requirements_sched.length>0 && !form.requirements_result.length>0">
                        <div v-for="step in steps.step_req" v-bind:key="step.id">
                            <div class="container bg-light">
                                <p v-if="form.requirements==1">Adviser</p>
                                <p v-if="form.requirements==2">File</p>
                                <p v-if="form.requirements==3">Panel</p>
                                <p v-if="form.requirements==4">Result</p>
                                <p v-if="form.requirements==5">Schedule</p>
                                <p v-if="form.requirements==6">Topic</p>
                                <div v-if="steps.step_data[0].complete=='Incomplete' && steps.step_data[0].status=='Active' && steps.track_status[0].status=='Active' && enrollmentStatus==0">
                                    <button @click="showAssignAdviser()" v-if="form.requirements=='1'" class="btn btn-sm btn-dark">Assign New Adviser</button>
                                    <button @click="showUploadFile()" v-if="form.requirements=='2'" class="btn btn-sm btn-dark">Upload New File</button>
                                    <button @click="showAssignPanel(step)" v-if="form.requirements=='3'" class="btn btn-sm btn-dark">Assign New Panel</button>
                                    <button @click="showCreateTopic()" v-if="form.requirements=='6'" class="btn btn-sm btn-dark">Create</button>
                                    <button @click="showCreateSched()" v-if="form.requirements=='5'" class="btn btn-sm btn-dark">Create</button> 
                                    <button @click="showCreateRes()" v-if="form.requirements=='4'" class="btn btn-sm btn-dark">Create</button> 
                                    <button @click="deleteReq(step.id)" class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="form.requirements_data.length>0">
                            <div v-for="req in form.requirements_data" v-bind:key="req.id">
                                <div class="container bg-light">
                                    <table class="table table-sm table-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th v-if="form.step=='Assign Adviser'">Adviser Details</th>
                                            </tr>
                                            <tr>
                                                <td>Fullname: </td>
                                                <td>{{req.last_name}},{{req.first_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Contact:</td>
                                                <td>{{req.contact_number}}</td>
                                            </tr>
                                            <tr>
                                                <td>Email:</td>
                                                <td>{{req.email}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.requirements_topic.length>0">
                            <div v-for="req in form.requirements_topic" v-bind:key="req.id">
                                <div class="container bg-light">
                                    <table class="table table-sm table-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Topic Details</th>
                                            </tr>
                                            <tr>
                                                <td>Title: </td>
                                                <td>{{req.topic}}</td>
                                            </tr>
                                            <tr>
                                                <td>Remarks:</td>
                                                <td>{{req.remarks}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.requirements_sched.length>0">
                            <div v-for="req in form.requirements_sched" v-bind:key="req.id">
                                <div class="container bg-light">
                                    <table class="table table-sm table-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Schedule Details</th>
                                            </tr>
                                            <tr>
                                                <td>Date: </td>
                                                <td>{{req.date}}</td>
                                            </tr>
                                            <tr>
                                                <td>Start:</td>
                                                <td>{{req.start_time}}</td>
                                            </tr>
                                            <tr>
                                                <td>End:</td>
                                                <td>{{req.end_time}}</td>
                                            </tr>
                                            <tr>
                                                <td>Room:</td>
                                                <td>{{req.room}}</td>
                                            </tr>
                                            <tr>
                                                <td>Remarks:</td>
                                                <td>{{req.remarks}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.requirements_result.length>0">
                            <div v-for="req in form.requirements_result" v-bind:key="req.id">
                                <div class="container bg-light">
                                    <table class="table table-sm table-borderless">
                                        <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>Result Details</th>
                                            </tr>
                                            <tr>
                                                <td>Result:</td>
                                                <td>{{req.result}}</td>
                                            </tr>
                                            <tr>
                                                <td>Remark:</td>
                                                <td>{{req.remarks}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-center py-2">
                        <a class="m-1 text-dark" href=""><h4></h4></a>
                </div>
            </div>
        </div>
        <!-- Edit Step Modal -->
        <div class="modal fade" id="editTrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Step</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveEditStep()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <div>
                                    <label for="c-sname">Step name</label>
                                    <input id="c-sname" type="text" name="c-sname"
                                     v-model="form.step"
                                     placeholder="Step name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                    <has-error :form="form" field="c-sname"></has-error>
                                </div>
                                <div>
                                    <label for="c-sno">Step number</label>
                                    <input id="c-sno" type="text"
                                    placeholder="Step number..."
                                     v-model="form.step_number"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sno') }">
                                    <has-error :form="form" field="c-sno"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="c-course">Requirement(s)(optional)</label>
                                <span v-if="steps.step_data">
                                    <div class="form-check">
                                        <input v-model="form.requirements" type="radio" value="1" :checked="form.requirements=='1'">
                                        <span class="checkbox-label">Adviser</span><br>
                                        <input v-model="form.requirements" type="radio" value="2" :checked="form.requirements=='2'"> 
                                        <span class="checkbox-label">File</span><br>
                                        <input v-model="form.requirements" type="radio" value="3" :checked="form.requirements=='3'"> 
                                        <span class="checkbox-label">Panel</span><br>
                                        <input v-model="form.requirements" type="radio" value="4" :checked="form.requirements=='4'"> 
                                        <span class="checkbox-label">Result</span><br>
                                        <input v-model="form.requirements" type="radio" value="5" :checked="form.requirements=='5'"> 
                                        <span class="checkbox-label">Schedule</span><br>
                                        <input v-model="form.requirements" type="radio" value="6" :checked="form.requirements=='6'"> 
                                        <span class="checkbox-label">Topic</span><br>
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
        <!-- Assign Adviser Modal -->
        <div class="modal fade" id="assignAdviser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Adviser</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveAdviser()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <label>Adviser:</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-sem" v-model="form.a_adviser" name="c-sem" required>
                                    <option selected value="">Select Adviser...</option>
                                    <option v-for="adv in advisers" v-bind:key="adv.id" v-bind:value="adv.id"> 
                                        {{adv.last_name}}, {{adv.first_name}}
                                    </option>
                                </select>
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
        <!-- Upload File Modal -->
        <div class="modal fade" id="uploadFile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="uploadFile()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <label>Select File</label>
                                <input type="file" class="form-control" @change="processFile($event)">
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
        <!-- Assign Panel Modal -->
        <div class="modal fade" id="assignPanel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Assign Adviser</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveAssignPanel()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <label>External Panel:</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-sem" v-model="form.e_panel" name="c-sem" required>
                                    <option selected value="">Select External Panel...</option>
                                    <option v-for="adv in e_advisers" v-bind:key="adv.id" v-bind:value="adv.id"> 
                                        {{adv.last_name}}, {{adv.first_name}}
                                    </option>
                                </select>
                            </div>
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <label>Internal Panel:</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-sem" v-model="form.i_panel" name="c-sem" required>
                                    <option selected value="">Select Internal Panel...</option>
                                    <option v-for="adv in i_advisers" v-bind:key="adv.id" v-bind:value="adv.id"> 
                                        {{adv.last_name}}, {{adv.first_name}}
                                    </option>
                                </select>
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
        <!-- Create Topic Modal -->
        <div class="modal fade" id="createTopic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Topic</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveTopic()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <label>Topic:</label>
                                <div>
                                    <input id="c-sname" type="text" name="c-sname"
                                     v-model="form.topic"
                                     placeholder="Topic name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                    <has-error :form="form" field="c-sname"></has-error>
                                </div>
                                <label>Remarks (Optional):</label>
                                <div>
                                    <input id="c-sname" type="textbox" name="c-sname"
                                     v-model="form.t_remarks"
                                     placeholder="Remarks..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                    <has-error :form="form" field="c-sname"></has-error>
                                </div>
                            </div>
                            <div><font color="red"></font></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Create Schedule Modal -->
        <div class="modal fade" id="createSched" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Schedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveSched()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Date:</label>
                                        <input id="c-sname" type="date" name="c-sname"
                                        v-model="form.s_date"
                                        placeholder="Date"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                        <has-error :form="form" field="c-sname"></has-error>
                                    </div>
                                    <div class="col">
                                        <label>Start Time:</label>
                                        <input id="c-sname" type="time" name="c-sname"
                                        v-model="form.s_start"
                                        placeholder="Start"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                        <has-error :form="form" field="c-sname"></has-error>
                                    </div>
                                    <div class="col">
                                        <label>End Time:</label>
                                        <input id="c-sname" type="time" name="c-sname"
                                        v-model="form.s_end"
                                        placeholder="End"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                        <has-error :form="form" field="c-sname"></has-error>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Room:</label>
                                        <input id="c-sname" type="text" name="c-sname"
                                        v-model="form.s_room"
                                        placeholder="Room number"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                        <has-error :form="form" field="c-sname"></has-error>
                                    </div>
                                    <div class="col">
                                        <label>Remarks:</label>
                                        <input id="c-sname" type="text" name="c-sname"
                                        v-model="form.s_remarks"
                                        placeholder="Remarks"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                        <has-error :form="form" field="c-sname"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div><font color="red"></font></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Create Result Modal -->
        <div class="modal fade" id="createRes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Schedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveRes()">
                        <div class="modal-body">
                            <div><font color="red"></font></div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="form-check">
                                        <label>Result:</label>
                                        <br>
                                        <input v-model="form.r_result" type="radio" value="1">
                                        <span class="checkbox-label">Passed</span><br>
                                        <input v-model="form.r_result" type="radio" value="2"> 
                                        <span class="checkbox-label">Failed</span><br>
                                        <input v-model="form.r_result" type="radio" value="3"> 
                                        <span class="checkbox-label">Revision</span><br>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label>Remarks:</label>
                                        <input id="c-sname" type="text" name="c-sname"
                                        v-model="form.r_remarks"
                                        placeholder="Remarks"
                                        class="form-control" :class="{ 'is-invalid': form.errors.has('c-sname') }">
                                        <has-error :form="form" field="c-sname"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div><font color="red"></font></div>
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
            moment: moment,
            steps: {},
            enrollmentStatus: '',
            advisers: {},
            e_advisers: {},
            i_advisers:{},
            form: new Form({
                step: '',
                step_number: '',
                tracking_step_id: '',
                requirements: '',
                requirements_data: {},
                requirements_topic: {},
                requirements_sched: {},
                requirements_result: {},
                a_adviser: '',
                requirement_id: '',
                file: null,
                e_panel: '',
                i_panel: '',
                topic: '',
                t_remarks: '',
                s_date: '',
                s_start: '',
                s_end: '',
                s_room: '',
                s_remarks: '',
                r_result: '',
                r_remarks: ''
            }),
            
        }
    },
    methods:{
        getStepData(){
            axios.post('../api/getStepData/'+this.data_id)
            .then(response=>{
                this.steps = response.data;
                let requirements = [];
                $.each(response.data.step_req, function(key, value) {
                    if(response.data.step_req[key].requirement=="Adviser"){
                        requirements='1';
                    }else if(response.data.step_req[key].requirement=="File"){
                        requirements='2';
                    }else if(response.data.step_req[key].requirement=="Panel"){
                        requirements='3';
                    }else if(response.data.step_req[key].requirement=="Result"){
                        requirements='4';
                    }else if(response.data.step_req[key].requirement=="Schedule"){
                        requirements='5';
                    }else if(response.data.step_req[key].requirement=="Topic"){
                        requirements='6';
                    }
                    
                });
                this.form.step = response.data.step_data[0].step_name;
                this.form.step_number = response.data.step_data[0].step_number;
                this.form.requirements = requirements;
                this.form.tracking_step_id = response.data.step_data[0].id;
                this.form.requirement_id = response.data.step_req[0].id;
                let enrollment_status = response.data.track_status[0].enrollment_status;
                if(enrollment_status == 2 || enrollment_status == 3 || enrollment_status == 4){
                    this.enrollmentStatus = 1;
                }else{
                    this.enrollmentStatus = 0;
                }
                if(response.data.step_req[0].requirement=="Adviser"){
                    axios.post('../api/getFacultyReq/'+response.data.step_req[0].id)
                    .then(response=>{
                        this.form.requirements_data = response.data
                    })
                }else if(response.data.step_req[0].requirement=="Panel"){
                    axios.post('../api/getFacultyReq/'+response.data.step_req[0].id)
                    .then(response=>{
                        this.form.requirements_data = response.data
                    })
                }else if(response.data.step_req[0].requirement=="Topic"){
                    axios.post('../api/getTopicReq/'+response.data.step_req[0].id)
                    .then(response=>{
                        this.form.requirements_topic = response.data
                    })
                }else if(response.data.step_req[0].requirement=="Schedule"){
                    axios.post('../api/getSchedReq/'+response.data.step_req[0].id)
                    .then(response=>{
                        this.form.requirements_sched = response.data
                    })
                }else if(response.data.step_req[0].requirement=="Result"){
                    axios.post('../api/getResultReq/'+response.data.step_req[0].id)
                    .then(response=>{
                        this.form.requirements_result = response.data
                    })
                }
            });
        },
        saveAdviser(){
            this.form.post('../api/saveAdviser')
            .then(response=>{
                this.getStepData();
                $('#assignAdviser').modal('hide');
            })
        },
        completeStep(id){
            axios.post('../api/completeStep/'+id)
            .then(()=>{
                this.getStepData();
            }).catch(()=>{
            });
        },
        getAdvisers(){
            axios.get('../api/getAdvisers')
            .then(response=>{
                this.advisers = response.data;
            })
        },
        incompleteStep(id){
            axios.post('../api/incompleteStep/'+id)
            .then(()=>{
                this.getStepData();
            }).catch(()=>{
            });
        },
        deacStep(id){
            axios.post('../api/deacStep/'+id)
            .then(()=>{
                this.getStepData();
            }).catch(()=>{
            });
        },
        activateStep(id){
            axios.post('../api/activateStep/'+id)
            .then(()=>{
                this.getStepData();
            }).catch(()=>{
            });
        },
        deleteStep(id){
            axios.post('../api/deleteStep/'+id)
            .then(response=>{
                window.location = "/enrollmentTrack/"+response.data;
            }).catch(()=>{
            });
        },
        deleteReq(id){
            axios.post('../api/deleteReq/'+id)
            .then(response=>{
                this.getStepData();
            })
        },
        editStep(){
            $('#editTrack').modal('show');
        },
        checkReq(requirement){
            return true;
        },
        saveEditStep(){
            this.form.post('../api/saveEditStep')
           .then(response => {
               $('#editTrack').modal('hide');
               this.getStepData();
           }).catch(error =>{
               console.log('response');
           })
        },
        duplicateStep(id){
            axios.post('../api/duplicateStep/'+id)
            .then(response=>{
                window.location = "/viewStep/"+response.data;
            }).catch(()=>{
                
            })
        },
        showAssignAdviser(){
            $('#assignAdviser').modal('show');
        },
        showUploadFile(){
            $('#uploadFile').modal('show');
        },
        processFile(event){
            this.form.file = event.target.files[0];
        },
        uploadFile(){
            this.form.post('../api/saveFile')
            .then(response=>{

            })
        },
        showAssignPanel(){
            $('#assignPanel').modal('show');
        },
        saveAssignPanel(){
            this.form.post('../api/assignPanel')
            .then(response=>{
                this.getStepData();
                $('#assignPanel').modal('hide');
            })
        },
        showCreateTopic(){
            $('#createTopic').modal('show');
        },
        saveTopic(){
            this.form.post('../api/saveTopic')
            .then(response=>{
                this.getStepData();
                $('#createTopic').modal('hide');
            })
        },
        showCreateSched(){
            $('#createSched').modal('show');
        },
        saveSched(){
            this.form.post('../api/saveSched')
            .then(response=>{
                this.getStepData();
                $('#createTopic').modal('hide');
            })
        },
        showCreateRes(){
            $('#createRes').modal('show');
        },
        saveRes(){
            this.form.post('../api/saveRes')
            .then(response=>{
                $('#createRes').modal('hide');
            })
        },
        getExternalPanel(){
            axios.get('../api/getExternalPanel')
            .then(response=>{
                this.e_advisers = response.data;
            })
        },
        getInternalPanel(){
            axios.get('../api/getInternalPanel')
            .then(response=>{
                this.i_advisers = response.data;
            })
        }
    },
    created(){
        this.getStepData();
        this.getAdvisers();
        this.getExternalPanel();
        this.getInternalPanel();
    }
}
</script>