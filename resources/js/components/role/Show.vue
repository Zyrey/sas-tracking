<template id="role">
  <div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <router-link to="/role/index" class="btn btn-dark btn-sm">Back</router-link>
        </div>

        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <h4>Details of {{role.id}}</h4>
                    <div>
                        <router-link class="btn btn-info btn-xs" v-bind:to="{name: 'RoleEdit', params: {id: role.id}}"><i class="fa fa-eye" aria-hidden="true"></i> Edit</router-link>
                    </div>
                </div>

                <div class="card-body">
                    <p>Role: {{ role.name }}</p>
                    <p>Description: {{ role.description }}</p>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header bg-primary">
                    <h5>List of Graduate Program Coordinator</h5>
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        
                            <li class="list-group-item d-flex justify-content-between">
                                <p>{{ }} (<a></a>)</p>
                                <span>{{  }}</span>
                            </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
   export default {
   data: function () {
   return {role: {name: '', description: ''}}
 },
 created: function(){
   let uri = 'http://localhost:8000/api/index/'+this.$route.params.id;
     Axios.get(uri).then((response) => {
     this.role = response.data;
   });
 }
 }
</script>