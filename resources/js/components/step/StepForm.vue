<template>
<div>
    <div class="row">
    <div class="form-group col">
        <label for="course_level_id">Course Level</label>
        <select class="form-control" name="course_level_id">
            <option value="" disabled>Select Course Level</option>
                <option class="form-control" value=""
                >
                </option>
                <option class="form-control" value="" disabled selected>No Course Level Available</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group col-md-8">
        <label for="step">Step Name</label>
        <input type="text" name="step" class="form-control" id="step"
               aria-describedby="stepHelp"
               value=""
               placeholder="Enter Step Name" autocomplete="off">
    </div>

    <div class="form-group col-md-4">
        <label for="step_number">Step Number</label>
        <input type="number" name="step_number" class="form-control"
               id="step_number" placeholder="Enter Step Number">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-8">
        <label>Requirements <small>(optional)</small></label>
        <div class="border px-2 py-2">

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="requirement1"
                       name="" value="1">
                <label class="custom-control-label" for="requirement1">Adviser</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="requirement2"
                       name="" value="2">
                <label class="custom-control-label" for="requirement2">File</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="requirement3"
                       name="" value="3">
                <label class="custom-control-label" for="requirement3">Panel</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="requirement4"
                       name="" value="4">
                <label class="custom-control-label" for="requirement4">Result (Pass / Revision / Fail)</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="requirement5"
                       name="" value="5">
                <label class="custom-control-label" for="requirement5">Schedule</label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="requirement6"
                       name="" value="6">
                <label class="custom-control-label" for="requirement6">Topic</label>
            </div>

        </div>
    </div>
</div>
</div>
</template>
