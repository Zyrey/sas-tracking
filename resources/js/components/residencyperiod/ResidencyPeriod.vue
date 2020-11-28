<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4>Edit Residency Period in </h4>
                        <a href="" class="btn btn-sm btn-dark">Back</a>
                    </div>

                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="month_start">Month Started</label>
                                    <select name="month_start" class="form-control" id="month_start">
                                      
                                            <option value="" >

                                            </option>
                             
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="year_start">Year Started</label>
                                    <input type="number" name="year_start" class="form-control" id="year_start">
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>