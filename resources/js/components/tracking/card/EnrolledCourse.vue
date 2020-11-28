<template>
    <div class="card mb-2">
    <div class="card-header">
        <h5></h5>


            <div class="d-flex justify-content-between">

                    <a href="" class="btn btn-dark btn-sm mr-1">Update Course</a>

                    <a href="" class="btn btn-dark btn-sm mr-1">Update Enrollment</a>

                    <span onclick="" class="btn btn-dark btn-sm">
                        Create New Tracking
                    </span>
                    <form style="display: none" id="form-create-tracking" action="" method="POST">
                    </form>
            </div>
    </div>
    <div class="card-body">
        <h6><strong></strong></h6>
        <table class="table table-sm table-borderless">
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><strong>Student Details</strong></td>
            </tr>
            <tr>
                <td>ID Number:</td>
                <td><a href=""> </a></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td></td>
            </tr>
            <tr>
                <td>Program:</td>
                <td></td>
            </tr>
            <tr>
                <td>Residency Period:</td>
                <td></td>
            </tr>
            <tr>
                <td><strong>Enrollment Details</strong></td>
            </tr>
            <tr>
                <td>Status:</td>
                <td></td>
            </tr>
            <tr>
                <td>Date Enrolled:</td>
                <td></td>
            </tr>
            <tr>
                <td>Last Updated:</td>
                <td></td>
            </tr>
            <tr>
                <td><strong>Course Details</strong></td>
            </tr>
            <tr>
                <td>Title:</td>
                <td></td>
            </tr>
            <tr>
                <td>Level:</td>
                <td></td>
            </tr>

            <tr>
                <td>Status:</td>
                <td></td>
            </tr>
            <tr>
                <td>Grade:</td>
                <td></td>
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
</template>

