<template>
<div>
    <div class="row">
    <div class="form-group col-md-6">
        <label for="student_id_number">Student ID Number</label>
        <input type="number" name="student_id_number" class="form-control" id="student_id_number">
    </div>

    <div class="form-group col-md-6">
        <label for="program_id">Program</label>
        <select class="form-control" name="program_id">
            <option value="">Select Program</option>
                    <option class="form-control" value="">
                    </option>
                <option class="form-control" value="" disabled selected>No Program Available</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label>Courses</label>
        <div class="border px-2 py-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id=""
                               name=""
                               value="">
                        <label class="custom-control-label"></label>
                    </div>
                <p class="text-warning">No Course Available</p>
        </div>
    </div>
</div>
</div>
</template>
