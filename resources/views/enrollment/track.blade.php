@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row float-left">
            <div class="col-md-6 col-sm-1 col-lg-12">
                <enrollmenttrack data_id="{{ $id }}"></enrollmenttrack>
            </div>
        </div>
        <div class="row float-right">
            <div class="col-md-6 col-sm-1 col-lg-12">
                <enrollmenttrack2 data_id="{{ $id }}"></enrollmenttrack2>
            </div>
        </div>
    </div>
@endsection
