<template>
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <a href="" class="btn btn-sm btn-dark">Back</a>
            </div>

            <div class="col-md-6">

                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between bg-primary">
                        <h4>Step
                        </h4>
                        <div class="d-flex">
                                <div>
                                    <a href="" class="btn btn-dark btn-sm mr-1">Edit</a>
                                    <span onclick="" class="btn btn-danger btn-sm">
                                        Delete
                                    </span>
                                    <form style="display: none" id="form-delete-trackingStep" action="" method="POST">
                                    </form>
                                </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                                <div>
                                        <span onclick="" class="btn btn-danger btn-sm">
                                            Mark as Incomplete
                                        </span>
                                        <form style="display: none" id="form-incomplete-trackingStep" action="" method="POST">
                                        <button type="submit" class="btn btn-sm btn-danger">Mark as Incomplete</button>
                                    </form>
                                        <span onclick=""
                                            class="btn btn-dark btn-sm">
                                            Mark as Complete
                                        </span>
                                        <form style="display: none" id="form-complete-trackingStep" action="" method="POST">
                                        </form>
                                </div>
                                <div class="d-flex">
                                        <span onclick="" class="btn btn-dark btn-sm mr-1">
                                            Duplicate Step
                                        </span>
                                        <form style="display: none" id="form-duplicate-trackingStep" action="" method="POST">
                                        </form>

                                        <span onclick="" class="btn btn-danger btn-sm">
                                            Deactivate
                                        </span>
                                        <form style="display: none" id="form-deactivate-trackingStep" action="" method="POST">
                                        </form>
                                        <span onclick="" class="btn btn-dark btn-sm">
                                            Activate
                                        </span>
                                        <form style="display: none" id="form-activate-trackingStep" action="" method="POST">
                                        </form>
                                </div>
                        </div>

                        <table class="table table-sm table-borderless">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>Step Details</th>
                            </tr>
                            <tr>
                                <td>Status:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Completion Status:</td>
                                <td>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>No. of Takes:</td>
                                <td></td>
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
                                <th>History of Changes</th>
                            </tr>
                                <tr>
                                    <td>
                                        <a href="">
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <h6><strong>Comments</strong></h6>
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
                                            <form style="display: none" id="form-delete-enrolledCourseComment" action="" method="POST">
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


            <div class="col-md-6">

                <div class="card mb-2">
                    <div class="card-header bg-primary d-flex justify-content-between">
                        <h4>Requirements</h4>
                    </div>

                    <div class="card-body">
                            <div class="bg-light">
                            </div>
                            <div class="bg-light">
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

                <div class="d-flex justify-content-center py-2">
                        <a class="m-1 text-dark" href=""><h4></h4></a>
                </div>
            </div>
        </div>

    </div>
</template>

