@extends('layouts.app')

@section('content')
<div class="container">
    <!-- set progressbar -->
    <vue-progress-bar></vue-progress-bar>
    <calendar :user="{{ auth()->user() }}"></calendar>
</div>
@endsection
