<template>
<div>
    <div class="row">
    <div class="form-group col-md-4">
        <label for="id_number">ID Number</label>
        <input type="number" name="id_number" class="form-control" id="id_number">
    </div>

    <div class="form-group col-md-4">
        <label for="institution_id">Institution</label>
        <select class="form-control" name="institution_id">
            <option value="">Select Institution</option>
                <option class="form-control" value="">
                </option>
                <option class="form-control" value="" disabled selected>No Institution Available</option>
        </select>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" class="form-control" id="first_name">
    </div>

    <div class="form-group col-md-4">
        <label for="middle_name">Middle Name</label>
        <input type="text" name="middle_name" class="form-control" id="middle_name">
    </div>

    <div class="form-group col-md-4">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" class="form-control" id="last_name">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" id="email">
    </div>

    <div class="form-group col-md-6">
        <label for="contact_number">Contact Number</label>
        <input type="number" name="contact_number" class="form-control" id="contact_number">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label>Select Clusters to handle</label>
        <div class="border px-2 py-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id=""
                               name=""
                               value="">
                        <label class="custom-control-label" for=""></label>
                    </div>
        </div>
    </div>

    <div class="form-group col-md-6">
        <label>Select Courses to handle</label>
        <div class="border px-2 py-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id=""
                               name=""
                               value=""
                        >
                        <label class="custom-control-label" for=""></label>
                    </div>
        </div>
    </div>
</div>
</div>
</template>
