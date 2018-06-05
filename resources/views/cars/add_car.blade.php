@extends('layouts.app')

@section('content')
    <h1>Add Car</h1>
    {!! Form::open(['action' => 'CarsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('model', 'Model')}}
            {{Form::text('model', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>

        <div class="form-group">
            {{Form::label('brand', 'Brand')}}
            {{Form::text('brand', '', ['class' => 'form-control', 'placeholder' => 'brand'])}}
        </div>

        <div class="form-group">
            {{Form::label('color', 'Color')}}
            {{Form::text('color', '', ['class' => 'form-control', 'placeholder' => 'color'])}}
        </div>

       
        
        
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection





