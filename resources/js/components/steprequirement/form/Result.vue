<template>
<div>
    <div class="form-group">
    <label for=""></label>
    <div class="border px-3 py-3">
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="result1"
                   name="result"
                   value="1">
            <label class="custom-control-label" for="result1">
                Passed
            </label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="result2"
                   name="result"
                   value="2">
            <label class="custom-control-label" for="result2">
                Failed
            </label>
        </div>
        <div class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" id="result3"
                   name="result"
                   value="3">
            <label class="custom-control-label" for="result3">
                Revision
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="">Remarks <small>(Optional)</small></label>
    <textarea class="form-control" name="remarks" id="remarks"
              rows="3"></textarea>
</div>

<div class="form-group d-flex flex-column">
    <label for="">Attach Forms:</label>
    <input type="file" id="forms" name="">
</div>
</div>
</template>
