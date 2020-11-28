<template>
    <div class="row">
    <div class="form-group col-md-6">
        <label for="date">Date</label>
        <input type="date" name="date" class="form-control" id="date"
               value="">
    </div>

    <div class="form-group col-md-3">
        <label for="">Start Time</label>
        <input type="time" name="start_time" class="form-control" id="start_time"
               value="">
    </div>

    <div class="form-group col-md-3">
        <label for="">End Time</label>
        <input type="time" name="end_time" class="form-control" id="end_time"
               value="">
    </div>

    <div class="form-group col-md-6">
        <label for="">Room</label>
        <input type="text" name="room" class="form-control" id="room"
               placeholder="Enter Room Number" value="">
    </div>

    <div class="form-group col-md-12">
        <label for="">Remarks <small>(Optional)</small></label>
        <textarea class="form-control" name="remarks"
                  id="remarks" rows="3"></textarea>
    </div>

    <div class="form-group col-md-12 d-flex flex-column">
        <label for="">Attach Forms:</label>
        <input type="file" id="forms" name="">
    </div>
</div>
</template>

