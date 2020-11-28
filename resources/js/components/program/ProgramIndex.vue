<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>List of Programs</h4>
                        <div>
                            <button @click="showCreate()" class="btn btn-sm btn-dark">Create New Program</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Program</th>
                                    <th>Cluster</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                        <tr v-for="programs in program" v-bind:key="programs.id">
                                            <td>{{programs.id}}</td>
                                            <td>{{programs.program}}</td>
                                            <td>{{programs.cluster.cluster}}</td>
                                            <td>{{programs.type}}</td>
                                            <td>
                                                <button @click="viewProgram(programs)" class="btn btn-sm btn-primary">View</button>
                                                <button @click="editProgram(programs)" class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                    <tr>
                                        <td>No Programs to Show</td>
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
        <!-- Create Program Modal -->
        <div class="modal fade" id="createProgram" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createProgram()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input id="c-program" v-model="form.program" type="text" name="c-program"
                                    placeholder="Program name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }">
                                    <has-error :form="form" field="c-program"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-cluster">Cluster</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-cluster" v-model="form.cluster_id" name="c-cluster" required>
                                    <option selected value="">Select Clusters...</option>
                                    <option v-for="clu in clusters" v-bind:key="clu.id" v-bind:value="clu.id"> 
                                        {{clu.cluster}}
                                    </option>
                                </select>
                                <has-error :form="form" field="c-cluster"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-type">Type</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-type" v-model="form.type" name="c-type" required>
                                    <option selected value="">Select Type...</option>
                                    <option value="1">Masters</option>
                                    <option value="2">Doctorate</option>
                                </select>
                                <has-error :form="form" field="c-type"></has-error>
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
        <!-- View Program Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <input id="c-program" v-model="form.program" type="text" name="c-program"
                                    placeholder="Program name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }" readonly>
                                    <has-error :form="form" field="c-program"></has-error>
                            </div>
                            <div class="form-group">
                                <input id="c-cluster_id" v-model="form.cluster_id" type="text" name="c-cluster_id"
                                    placeholder="Cluster"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-cluster_id') }" readonly>
                                    <has-error :form="form" field="c-cluster_id"></has-error>
                            </div>
                            <div class="form-group">
                                <input id="c-type" v-model="form.type" type="text" name="c-type"
                                    placeholder="Type"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-type') }" readonly>
                                    <has-error :form="form" field="c-type"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Edit Program Modal -->
        <div class="modal fade" id="editProgram" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Program</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="saveProgram()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input id="c-program" v-model="form.program" type="text" name="c-program"
                                    placeholder="Program name..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('c-program') }">
                                    <has-error :form="form" field="c-program"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-cluster">Cluster</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-cluster" v-model="form.cluster_id" name="c-cluster" required>
                                    <option selected value="">Select Clusters...</option>
                                    <option v-for="clu in clusters" v-bind:key="clu.id" v-bind:value="clu.id"> 
                                        {{clu.cluster}}
                                    </option>
                                </select>
                                <has-error :form="form" field="c-cluster"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="c-type">Type</label>
                                <select class="custom-select my-1 mr-sm-2" id="c-type" v-model="form.type" name="c-type" required>
                                    <option selected value="">Select Type...</option>
                                    <option value="1">Masters</option>
                                    <option value="2">Doctorate</option>
                                </select>
                                <has-error :form="form" field="c-type"></has-error>
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
            program:[],
            clusters: {},
            form: new Form({
                program: '',
                cluster_id: '',
                type: '',
                id: ''
            })
        }
    },
    methods:{
        getprogram(){
            axios.get('api/programlist')
            .then(response => this.program = response.data);
        },
        showCreate(){
            $('#createProgram').modal('show');
        },
        getClusters(){
            axios.get('api/getClusters')
            .then(response=>{
                this.clusters = response.data;
            })
        },
        createProgram(){
            this.form.post('api/createProgram')
            .then(response=>{
                this.getprogram();
                $('#createProgram').modal('hide');
            })
        },
        viewProgram(data){
            this.form.fill(data);
            $('#viewModal').modal('show');
        },
        editProgram(data){
            this.form.fill(data);
            if(data.type=="Masters"){
                this.form.type="1";
            }else{
                this.form.type="2";
            }
            $('#editProgram').modal('show');
        },
        saveProgram(){
            this.form.post('api/saveProgram')
            .then(response=>{
                this.getprogram();
                $('#editProgram').modal('hide');
            })
        }

    },
    created(){
        this.getprogram();
        this.getClusters();
    }
}
</script>