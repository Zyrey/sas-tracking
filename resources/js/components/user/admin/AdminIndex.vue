<template>
   <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <h4>List of Admin Accounts</h4>
                    <div>
                        <a href="" class="btn btn-dark btn-sm">Create New Admin Account</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="admin in admins" v-bind:key="admin.id">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="" class="btn btn-sm btn-primary mr-2">View</a>
                                            <a href="" class="btn btn-sm btn-warning mr-2">Edit</a>
                                                <form action="" method="POST">
                                                    <button type="submit" class="btn btn-sm btn-danger">Deactivate</button>
                                                </form>
                                                <form action="" method="POST">
                                                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                                </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
</template>
<script>
export default {
    data (){
    return{
        admin: [],
        admins:{
            id: '',
            cluster: ''
        }
    }
},
created (){
    this.getadmin();
},
methods:{
    showform(){
        let element = this.$refs.modal.$el
        $(element).modal('show')
        },
    getadmin(){
        axios.get('admin')
        .then(resp => this.admin = resp.data)
    }
} 
}
</script>
