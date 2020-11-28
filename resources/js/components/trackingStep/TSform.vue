<template>
<div>
    <div class="row">
    <div class="form-group col-md-8">
        <label for="step_name">Step Name</label>
        <input type="text" name="step_name" class="form-control" id="step_name"
               value=""
               placeholder="Enter Step Name">
    </div>

    <div class="form-group col-md-4">
        <label for="step_number">Step Number</label>
        <input type="number" name="step_number" class="form-control" id="step_number"
               value=""
               placeholder="Enter Step Number">
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

