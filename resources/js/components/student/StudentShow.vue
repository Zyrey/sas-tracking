<template>
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <a href="" class="btn btn-sm btn-dark">Back</a>
            </div>

            <div class="col-md-6">

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
                                <div class="d-flex justify-content-between">
                                    <h4>Transcript of Records for </h4>
                                    <div>
                                        <a href="" class="btn btn-sm btn-dark">Update Residency Period</a>
                                    </div>
                                </div>
                                    <p>Residency Period: <strong></strong></p>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                            <h6><strong></strong></h6>
                                            <table class="table border">
                                                <thead>
                                                <tr>
                                                    <th>Course Number</th>
                                                    <th>Descriptive Title</th>
                                                    <th>Take</th>
                                                    <th>Grade</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <a href="" class="btn btn-primary btn-sm">View Details</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                </div>
                            </div>
                        </div>
            </div>



            <div class="col-md-6">
                    <div class="card mb-2">
                        <div class="card-header bg-primary d-flex justify-content-between">
                            <h4>Enrollments</h4>
                            <h4></h4>
                        </div>
                        <div class="card-body">
                                    <h4 class="border-bottom"></h4>
                                        <table class="table border">
                                            <thead>
                                            <tr>
                                                <th>Course Number</th>
                                                <th>Descriptive Title</th>
                                                <th>Take</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="" >
                                                    <td></td>
                                                    <td></td>
                                                    <td> take</td>
                                                    <td></td>
                                                    <td>
                                                        <a href="" class="btn btn-primary btn-sm">View Details</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <h4>No Enrollments Found</h4>
                                <p>No Enrollments Found</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>No Current Semester</h4>
                            <a href="" class="btn btn-success btn-sm">Update Semester</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>