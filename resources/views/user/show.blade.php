@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <usershow user_email="{{ $user_email }}"></usershow>
    </div>
</div>
@endsection
