<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header bg-info">
                    <div>
                        <h5>Create New GPC Account</h5>

                        <a href="" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="">

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="cluster_id">Cluster</label>
                                <select name="cluster_id" id="cluster_id" class="form-control">
                                    <option value="">Select Cluster</option>
                                        <option value="">
                                        </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" name="password_confirmation" class="form-control" >
                            </div>
                        </div>

                        <div class="row pt-2">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Create Account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
