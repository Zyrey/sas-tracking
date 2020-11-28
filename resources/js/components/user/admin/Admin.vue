<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <h4>List of Admin Accounts</h4>
                    <div>
                        <router-link class="btn btn-info btn-xs" to="/admin/create/"><i class="fa fa-eye" aria-hidden="true"></i>Create</router-link>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{}}</td>
                                    <td>{{}}</td>
                                    <td>{{}}</td>
                                    <td>{{}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <router-link class="btn btn-info btn-xs" to="/user/show/"><i class="fa fa-eye" aria-hidden="true"></i> Show</router-link>
                                            <router-link class="btn btn-info btn-xs" to="/user/edit/"><i class="fa fa-eye" aria-hidden="true"></i> Edit</router-link>
                                            @if($user->status == 'Active')
                                                <form action="{{}}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-danger">Deactivate</button>
                                                </form>
                                            @else
                                                <form action="{{}}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>