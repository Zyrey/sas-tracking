<template>
    <div class="container">
    <div class="row justify-content-center">

        <div class="col">
            <a href="{{}}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4>Create New Admin Account</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{}}">
                        <input type="hidden" name="is_admin" value="1">

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="role_id">Role</label>
                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">Select Role</option>
                                    
                                        <option value="{{}}"
                                            
                                            
                                        >
                                            
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @include('user.form')

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

                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary">Create Account</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>