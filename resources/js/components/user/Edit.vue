<template>
    <div class="container">
    <div class="row justify-content-center">


        @auth('superadmin')
        <div class="col">
            @if($user->is_admin)
                <a href="{{}}" class="btn btn-dark btn-sm">Back</a>
            @else
                <a href="{{}}" class="btn btn-dark btn-sm">Back</a>
            @endif
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4>Edit Details of {{}}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{}}">
                        @method('PATCH')

                        @if($user->is_admin)
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="role_id">Role</label>
                                    <select name="role_id" id="role_id" class="form-control">
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{}}"
                                                
                                                
                                            >
                                                
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cluster_id">Cluster</label>
                                    <select name="cluster_id" id="cluster_id" class="form-control">
                                        <option value="">Select Cluster</option>
                                        @foreach($clusters as $cluster)
                                            <option value="{{}}"
                                                
                                            >
                                                
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        @include('user.form')

                        <div class="row pt-2">
                            <div class="col-md-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endauth

       
        @auth('web')
            <div class="col">
                <a href="{{}}" class="btn btn-dark btn-sm">Back</a>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h4>Edit Details of {{}}</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{}}">
                            @method('PATCH')
                            @include('user.form')

                            <div class="row pt-2">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</div>
</template>