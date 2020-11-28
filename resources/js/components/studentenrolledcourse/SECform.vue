<template>
<div>
<div class="form-group">
    <label for="enrollment_status">Enrollment Status</label>
    <select class="form-control" name="enrollment_status">
        <option class="form-control" value="0" >Enrolled</option>
        <option class="form-control" value="1" >Incomplete</option>
        <option class="form-control" value="2" >Dropped</option>
        <option class="form-control" value="3" >Withdraw</option>
        <option class="form-control" value="4" >Completed</option>
    </select>
    <span class="invalid-feedback" role="alert"><strong></strong></span>
</div>


<div class="row">
    <div class="form-group col-md-6">
        <label for="course_status">Course Status</label>
        <select class="form-control " name="course_status">
            <option class="form-control" value="0" >Failed</option>
            <option class="form-control" value="1" >In Progress</option>
            <option class="form-control" value="2" >Passed</option>
        </select>
        <span class="invalid-feedback" role="alert"><strong></strong></span>
    </div>

    <div class="form-group col-md-6">
        <label for="grade">Grade</label>
        <input class="form-control" type="text" name="grade" id="grade">
        <span class="invalid-feedback" role="alert"><strong></strong></span>
    </div>
</div>

<div class="form-group">
    <label for="remarks">Comments<small>(Optional)</small></label>
    <textarea class="form-control" name="remarks" id="remarks" rows="3"></textarea>
    <span class="invalid-feedback" role="alert"><strong></strong></span>
</div>
</div>
</template>
