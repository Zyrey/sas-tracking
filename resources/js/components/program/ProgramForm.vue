<template>
<div>
    <div class="form-row mb-3">
    <div class="col">
        <label for="cluster_id">Cluster</label>
        <select class="form-control" name="cluster_id">
            <option value="" disabled>Select Cluster</option>
                    <option class="form-control" value="">
                      
                    </option>

                <option class="form-control" value="" disabled selected>No Cluster Available</option>

        </select>
    </div>
</div>


<div class="form-row mb-3">
    <div class="col">
        <label for="program">Program</label>
        <input type="text" name="program" class="form-control"
               id="program">
    </div>

    <div class="col">
        <label for="type">Type</label>
        <select class="form-control" name="type">
            <option value="" disabled>Select Type</option>
            <option class="form-control" value="1"
            >
                Masters
            </option>
            <option class="form-control" value="2"
            >
                Doctorate
            </option>
        </select>
    </div>
</div>
</div>
</template>
