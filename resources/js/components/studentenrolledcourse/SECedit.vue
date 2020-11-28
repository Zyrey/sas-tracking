<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5>Update </h5>
                        <a href="" class="btn btn-sm btn-dark">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="course_status">Course Status</label>
                                    <select class="form-control" name="course_status">
                                        <option class="form-control" value="0" >Failed</option>
                                        <option class="form-control" value="1" >In Progress</option>
                                        <option class="form-control" value="2" >Passed</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="grade">Grade</label>
                                    <input class="form-control" type="text" name="grade" id="grade" value="">
                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment">Comment <small>(Optional)</small></label>
                                <textarea class="form-control" name="comment" id="comment" rows="3" placeholder="Comment Here"></textarea>
                            </div>

                            <div class="row justify-content-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
