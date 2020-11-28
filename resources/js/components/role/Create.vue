<template>
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <router-link to="/role/index" class="btn btn-dark btn-sm">Back</router-link>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5>Create New Role</h5>
                </div>

                <div class="card-body">
                    <form @submit.prevent="saveRoles">
                        <input id='name' placeholder="Name" class="form-control m-2" v-model="form.name">
                        <input id='description' placeholder="Description" class="form-control m-2" v-model="form.description">
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>


import axios from 'axios'

  export default {
   
    data() {
      return {
          form:new Form({
              name: '',
              description: ''
          })
      }
    },
  
    methods: {
        saveRoles(){
            let data = new FormData();
            axios.post('/api/create', {
                ...this.form
            })
            .then(data => {
             this.$router.push({name: 'index'})
            })
            .catch((error) => {
             console.log(error);
        });
        }
    
    },
  
  }

</script>