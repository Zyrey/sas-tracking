<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between bg-primary">
                        <h4>List of Clusters</h4>
                        <div>
                            <!-- <a v-bind:href="ClusterForm" class="btn btn-dark btn-sm">Create New Cluster</a> -->
                            <button class="btn btn-dark btn-sm" @click="showform">Create New Cluster</button>
                            <ClusterForm ref="modal"></ClusterForm>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Cluster ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                    <tr v-for="clusters in cluster" v-bind:key="clusters.id">
                                        <td>{{clusters.id}}</td>
                                        <td>{{clusters.cluster}}</td>

                                        <td>
                                            <a href="" class="btn btn-primary btn-sm">View</a>
                                            <a href="" class="btn btn-warning btn-sm">Edit</a>
                                        </td>
                                    </tr>
                                
                                    <tr>
                                        <td>No Clusters to Show</td>
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
    </div>
</template>

<script>
import ClusterForm from './ClusterForm.vue';
export default {

data (){
    return{
        cluster: [],
        clusters:{
            id: '',
            cluster: ''
        }
    }
},
components:{
    'ClusterForm':ClusterForm,
},
created(){
    this.getcluster();
},
methods:{
    showform(){
        let element = this.$refs.modal.$el
        $(element).modal('show')
        },
    getcluster(){
        axios.get('api/clusterlist')
        .then(resp => this.cluster = resp.data)
    }
}      
}
</script>
