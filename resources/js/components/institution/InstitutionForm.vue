<template>
<div>
    <div class="row">
    <div class="form-group col-md-8">
        <label for="institution">Institution Name</label>
        <input type="text" name="institution" class="form-control" id="institution">
    </div>

    <div class="form-group col-md-4">
        <label for="type">Type</label>
        <select class="form-control" name="type">
            <option value="" disabled>Select Type</option>
            <option class="form-control" value="1"> </option>
            <option class="form-control" value="2"> </option>
        </select>
    </div>
</div>

<div class="row">
    <div class="form-group col">
        <label for="address">Address</label>
        <input type="text" name="address" class="form-control" id="address">
    </div>
</div>
</div>
</template>
