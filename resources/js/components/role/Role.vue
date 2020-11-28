<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <h4>List of Roles</h4>
                    <div>
                        <router-link to="/role/create" class="btn btn-dark btn-sm">Create New Role</router-link>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                                <tr v-for="role in roles" :key="role.id">
                                    <td>{{role.id}}</td>
                                    <td>{{role.name}}</td>
                                    <td>{{role.description}}</td>
                                    <td>
                                        <router-link class="btn btn-info btn-xs" v-bind:to="{name: 'RoleShow', params: {id: role.id}}"><i class="fa fa-eye" aria-hidden="true"></i> Show</router-link>
                                        <router-link class="btn btn-info btn-xs" v-bind:to="{name: 'RoleEdit', params: {id: role.id}}"><i class="fa fa-eye" aria-hidden="true"></i> Edit</router-link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>

import axios from 'axios'

export default {
    data:function(){
        return{
            roles: '',
        } ;
    },
    created(){
         this.getRoles()
         
     },
    methods: {
     async getRoles() {
      await axios
        .get("/api/index")
        .then(response => {
          this.roles = response.data;
          
        })
        .catch((error) => {
          console.log(error);
        });
    },
     
    },
}
</script>