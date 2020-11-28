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
                <div class="card-header d-flex justify-content-between bg-primary">
                    <h4>{{}}</h4>
                    <div class="d-flex">
                        <div>
                            <a href="{{}}" class="btn btn-sm btn-warning mr-2">Edit</a>
                        </div>
                        <div>
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
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tbody>
                        <tr>
                            <td>First Name:</td>
                            <td>{{}}</td>
                        </tr>
                        <tr>
                            <td>Middle Name:</td>
                            <td>{{}}</td>
                        </tr>
                        <tr>
                            <td>Last Name:</td>
                            <td>{{}}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{}}</td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td>{{}}</td>
                        </tr>
                        @if($user->is_admin)
                            <tr>
                                <td>Role:</td>
                                <td>{{}}</td>
                            </tr>
                        @else
                            <tr>
                                <td>Cluster:</td>
                                <td>{{}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
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
                    <div class="card-header d-flex justify-content-between bg-primary">
                        <h4>{{}}</h4>
                        <div class="d-flex">
                            <div>
                                <a href="{{}}" class="btn btn-sm btn-warning mr-2">Edit</a>
                                <a href="{{}}" class="btn btn-sm btn-dark mr-2">Change Password</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-borderless">
                            <tbody>
                            <tr>
                                <td>First Name:</td>
                                <td>{{}}</td>
                            </tr>
                            <tr>
                                <td>Middle Name:</td>
                                <td>{{}}</td>
                            </tr>
                            <tr>
                                <td>Last Name:</td>
                                <td>{{}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{}}</td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>{{}}</td>
                            </tr>
                            @if($user->is_admin)
                                <tr>
                                    <td>Role:</td>
                                    <td>{{}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>Cluster:</td>
                                    <td>{{}}</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endauth
        </div>
    </div>
</template>