@extends('layouts.app')

@section('content')
    <h1>Edit Car</h1>
    {!! Form::open(['action' => ['CarsController@update' , $car->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('model', 'Model')}}
            {{Form::text('model', $car->model, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>

        <div class="form-group">
            {{Form::label('brand', 'Brand')}}
            {{Form::text('brand', $car->brand, ['class' => 'form-control', 'placeholder' => 'brand'])}}
        </div>

        <div class="form-group">
            {{Form::label('color', 'Color')}}
            {{Form::text('color', $car->color, ['class' => 'form-control', 'placeholder' => 'color'])}}
        </div>

       
        {{Form::hidden('_method','PUT')}}
        
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection





