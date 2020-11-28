<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-header bg-primary">
                    <h5>Change Password</h5>
                        <a href="" class="btn btn-dark btn-sm">Back</a>
                        <a href="" class="btn btn-dark btn-sm">Back</a>
                </div>

                <div class="card-body">
                    <form method="POST" action="">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="current_password">Current Password</label>
                                <input id="current_password" type="password" name="current_password" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="new_password">New Password</label>
                                <input id="new_password" type="password" name="new_password" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="new_password-confirm">Confirm New Password</label>
                                <input id="new_password-confirm" type="password" name="new_password_confirmation" class="form-control" >
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
</template>
