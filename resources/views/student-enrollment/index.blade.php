@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <studenterollment 
            :idnumber='{{$student}}' 
            :enrollments='{{$enrollments}}' 
            :semester='{{$currentSemester}}'
        ></studenterollment>
    </div>
</div>
@endsection

