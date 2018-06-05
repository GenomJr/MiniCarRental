@extends('layouts.app')

@section('content')
    <a href="/Car" class="btn btn-default">Go Back</a>
    <h1>{{$car->brand}} {{$car->model}}</h1>
     <br><br>
     <small>Written on {{$car->created_at}} 
                            
        @if($car->isava ==1)

        <br>
        the car is available

        @elseif($car->isava ==0)
        <br>
        the car is busy
        @endif
        </small>
            <br><br>
    @if(!Auth::guest())
        @if(Auth::user()->id == $car->agency)
            <a href="/Car/{{$car->id}}/edit" class="btn btn-default">Edit</a>

            {!!Form::open(['action' => ['CarsController@destroy', $car->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!!Form::close()!!}
       
        @else
        
        {!! Form::open(['action' => ['RentController@store',$car->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
       
        <div class="form-group">
            {{Form::label('rent_start_month', 'Rent_start_month')}}
            {{Form::text('rent_start_month', '', ['class' => 'form-control', 'Rent month start' => 'Title'])}}
            {{Form::label('rent_start_day', 'Rent_start_day')}}
            {{Form::text('rent_start_day', '', ['class' => 'form-control', 'Rent day start' => 'Title'])}}
       
        </div>

        <div class="form-group">
            {{Form::label('rent_end_month', 'Rent_end_month')}}
            {{Form::text('rent_end_month', '', ['class' => 'form-control', 'Rent month end' => 'Title'])}}
            {{Form::label('rent_end_day', 'Rent_end_day')}}
            {{Form::text('rent_end_day', '', ['class' => 'form-control', 'Rent day end' => 'Title'])}}
       </div>
        
        {{Form::hidden('car_id', $car->id, ['class' => 'form-control'])}}
        {{Form::submit('Rent', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
        @endif
    @endif
@endsection