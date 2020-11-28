<template>
<div>
    <div class="row">
    <div class="form-group col-md-6">
        <label for="program_id">Program</label>
        <select class="form-control" name="program_id">
            <option value="">Select Program</option>
                    <option class="form-control" value="">
                    </option>
                <option class="form-control" value="" disabled selected>No Program Available</option>
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="course_level_id">Course Level</label>
        <select class="form-control" name="course_level_id">
            <option value="">Select Course Level</option>
                <option class="form-control" value="">
                </option>
                <option class="form-control" value="" disabled selected>No Course Level Available</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-3">
        <label for="course_number" class="col-form-label text-md-right"></label>
        <input id="course_number" type="text" class="form-control"
               name="course_number" value=""
               autocomplete="off" placeholder="Enter Course Number" autofocus>
    </div>

    <div class="form-group col-md-6">
        <label for="descriptive_title" class="col-form-label text-md-right"></label>
        <input id="descriptive_title" type="text" class="form-control"
               name="descriptive_title" value=""
               autocomplete="off" placeholder="Enter Descriptive Title" autofocus>
    </div>

    <div class="form-group col-md-3">
        <label for="units" class="col-form-label text-md-right">}</label>
        <input id="units" type="number" class="form-control"
               name="units" value=""
               autocomplete="off" placeholder="Enter Units" autofocus>
    </div>
</div>
</div>
</template>

