<template>
  <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a href="" class="btn btn-sm btn-dark">Back</a>
            </div>

            <div class="col-md-4">
                <div class="card mb-2">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4></h4>
                        <div class="d-flex">
                            <span>
                                <a href="" class="btn btn-dark btn-sm mr-1">Edit</a>
                            </span>
                                <form action="" method="POST">
                                    <button type="submit" class="btn btn-sm btn-danger">Deactivate</button>
                                </form>
                                <form action="" method="POST">
                                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                </form>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tbody>
                            <tr>
                                <th>Personal Information</th>
                            </tr>
                            <tr>
                                <td>ID Number:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>First Name:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Middle Name:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Last Name:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Contact No:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>School Information</th>
                            </tr>
                            <tr>
                                <td>Institution:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Cluster:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header bg-primary">
                        <h5>Clusters</h5>
                    </div>
                    <div class="card-body">
                            <h5>
                                <a href="" class="text-dark"></a>
                            </h5>
                            <h6><strong>Courses that can be handled</strong></h6>
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><a href="" class="btn btn-danger btn-sm">Remove</a></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>


            <div class="col-md-8">
                <div class="card mb-2">
                    <div class="card-header bg-primary">
                        <h5>Students</h5>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            
                            <div class="col-md-6">
                                <div class="d-flex justify-content-center">
                                    <h5>Advising</h5>
                                </div>
                                    <div class="border-bottom">
                                        <p><strong></strong></p>
                                    </div>
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                        <tr>
                                            <td>Status: </td>
                                                <td>Not Available</td>
                                                <td>Available</td>
                                        </tr>
                                        <tr>
                                            <td>Students:</td>
                                            <td>Total: </td>
                                            <td>Active: </td>
                                            <td>Inactive: </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Course</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td>
                                                    <a href="" target=""></a>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        <p>No Students to show.</p>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <div class="d-flex justify-content-center">
                                    <h5>Paneling</h5>
                                </div>
                                    <div class="border-bottom">
                                        <strong></strong>
                                    </div>
                                    <table class="table table-sm table-borderless table-secondary">
                                        <tbody>
                                        <tr>
                                            <td>Status: </td>
                                                <td>Not Available</td>
                                                <td>Available</td>
                                        </tr>
                                        <tr>
                                            <td>Students:</td>
                                            <td>Total: </td>
                                            <td>Active: </td>
                                            <td>Inactive: </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Course</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td>
                                                    <a href="" target=""></a>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        <p>No Students to show.</p>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>

</style>

