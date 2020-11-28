@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <!-- <div class="col">
            <a href="{{ route('superadmin.home') }}" class="btn btn-dark btn-sm">Back</a>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between bg-primary">
                    <div>
                        <h4>{{ $superadmin->email }}</h4>
                    </div>
                    <div class="d-flex">
                        <div>
                            <a href="{{ route('changepassword', $superadmin->email) }}" class="btn btn-sm btn-dark mr-2">Change Password</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tbody>
                        <tr>
                            <td>Name:</td>
                            <td>{{ $superadmin->name }}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{ $superadmin->email }}</td>
                        </tr>
                        <tr>
                            <td>Date Created:</td>
                            <td>{{ $superadmin->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Last Updated:</td>
                            <td>{{ $superadmin->updated_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div> -->
        <superadminshow></superadminshow>
    </div>
</div>
@endsection
