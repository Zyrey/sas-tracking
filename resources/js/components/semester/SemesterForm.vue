<template>
<div>
    <div class="form-row mb-3">
    <div class="col">
        <label for="term">Term</label>
        <select id="term" name="term" class="form-control">
            <option value="" disabled>Select Term</option>
            <option class="form-control" value="1" >First Semester</option>
            <option class="form-control" value="2" >Second Semester</option>
            <option class="form-control" value="3" >Short Term</option>
        </select>
    </div>
</div>

<div class="form-row mb-3">
    <div class="col">
        <label for="year_start">Year Start</label>
        <input id="year_start" type="text" class="form-control"
               name="year_start" value=""
               placeholder="Enter Year Start">
    </div>

    <div class="col">
        <label for="year_end">Year End</label>
        <input id="year_end" type="text" class="form-control"
               name="year_end" value=""
               placeholder="Enter Year End">
    </div>
</div>
</div>
</template>
