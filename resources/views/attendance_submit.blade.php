@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Confirmation</div>

                <div class="card-body">
                    <div class="alert alert-primary" role="alert">
                    Hello, {{ $person->name }} Your Attendance has been recorded Successfully!
                </div>
                <div style="float:right">
                <a href="{{ url('/') }}">Take attendance</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection