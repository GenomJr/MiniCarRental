
@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1><?php echo $title; ?></h1>
        <p>This is a Car Rental service simulation task implemented in Laravel 5.6 and php 7.2</p>
        <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
    </div>
@endsection
