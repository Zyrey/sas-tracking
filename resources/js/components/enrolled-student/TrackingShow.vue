<template>
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <a href="" class="btn btn-sm btn-dark">Back</a>
            </div>

            <div class="col-md-5">
                <div class="card mb-2">
                    <div class="card-header">
                        <h5>Details for Tracking </h5>
                                <span onclick="" class="btn btn-danger btn-sm">
                                    Deactivate
                                </span>
                                <form style="display: none" id="form-deactivate-tracking" action="" method="POST">
                                </form>
                                <span onclick="" class="btn btn-dark btn-sm">
                                    Activate
                                </span>
                                <form style="display: none" id="form-activate-tracking" action="" method="POST">
                                    <button type="submit" class="btn btn-sm btn-dark">Activate</button>
                                </form>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Tracking Details</th>
                            </tr>
                            <tr>
                                <td>ID:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Completion Status:</td>
                                <td> %</td>
                            </tr>
                            <tr>
                                <td>Date Created:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Last Updated:</td>
                                <td></td>
                            </tr>

                            <tr>
                                <th>Numbers of Active Steps</th>
                            </tr>
                            <tr>
                                <td>Total:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Completed:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Incomplete:</td>
                                <td></td>
                            </tr>

                            <tr>
                                <th>Default Steps</th>
                            </tr>
                                <tr>
                                    <td></td>
                                </tr>

                            <tr>
                                <th>Created Steps</th>
                            </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                        <h6><strong> Comments</strong></h6>
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
                                            <form style="display: none" id="" method="POST">
                                            </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h5>List of Steps</h5>
                            <a href="" class="btn btn-dark btn-sm">Add New Step</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex justify-content-between col-md-4 pb-2">
                                <div class="pr-3 pl-2 mr-1 rounded table-success"></div><span class="mr-1">Completed</span>
                                <div class="pr-3 pl-2 mr-1 rounded table-info"></div><span class="mr-1">Active</span>
                                <div class="pr-3 pl-2 mr-1 rounded table-secondary"></div><span class="mr-1">Inactive</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Take</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr class= "">
                                        <th></th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="">
                                            <a href="" class="btn btn-dark btn-sm mr-1">View</a>
                                                <a href="" class="btn btn-dark btn-sm mr-1">Edit</a>
                                        </td>
                                    </tr>
                                    <p>No Steps to Show</p>
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
    // data(){
    //     return{
    //         id:this.$route.params.id,
    //         track:[]
    //     }
    // },
    // methods:{
       
    // },
    // created(){
       
    // }
}
</script>