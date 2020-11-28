@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row float-left">
            <div class="col-md-6 col-sm-1 col-lg-12">
                <viewtrackstep data_id="{{ $id }}"></viewtrackstep>
            </div>
        </div>
    </div>
@endsection
