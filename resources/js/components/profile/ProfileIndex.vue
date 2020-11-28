<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <x-alert></x-alert>
            <x-superadmin-nav></x-superadmin-nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between bg-info">
                    <div>
                        <h4>List of GPC Accounts</h4>
                    </div>
                    <div>
                        <a href="" class="btn btn-dark btn-sm">Create New GPC Account</a>
                    </div>
                </div>

                <div class="card-body">
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
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="" class="btn btn-sm btn-primary mr-2">View</a>
                                        <a href="" class="btn btn-sm btn-warning mr-2">Edit</a>
                                            <form action="" method="POST">
                                                <button type="submit" class="btn btn-sm btn-danger">Deactivate</button>
                                            </form>
                                            <form action="" method="POST">
                                                <button type="submit" class="btn btn-sm btn-success">Activate</button>
                                            </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
