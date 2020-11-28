<template>
<div class="container">
        <h3 class="text-center">Edit Role</h3>
        <div class="row justify-content-center">
            <div class="col-md-12">
            <router-link to="/role/index" class="btn btn-dark btn-sm">Back</router-link>
        </div>
            <div class="col-md-6">
                <form @submit.prevent="updateRole">
                    <div class="form-group" >
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="role.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="role.description">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data:function(){
        return {
          role:new Form({
              name: '',
              description: ''
          })
      }
    },
    created: function(){
    let uri = 'http://localhost:8000/api/index/'+this.$route.params.id;
    Axios.get(uri).then((response) => {
    this.role = response.data;
  });
  },
  methods: {
    updateRole: function() {
      let uri = 'http://localhost:8000/api/index/'+this.$route.params.id;
      Axios.put(uri, this.role).then((response) => {
      this.$router.push({name: 'index'})
    })
  }
  }
}
</script>