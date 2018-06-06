@extends('layouts.app')

@section('content')
    <a href="/Car" class="btn btn-default">Go Back</a>
    <h1>{{$car->brand}} {{$car->model}}</h1>
    <h6> The Car color is {{$car->color}} </h6>
    <h6>Car agent :{{$car->agency_name}}</h6>
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
        
        {!! Form::open(['action' => ['RentController@destroy',$car->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
       
        
        {{Form::hidden('car_id', $car->id, ['class' => 'form-control'])}}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete this History', ['class' => 'btn btn-danger'])}}
        {!! Form::close() !!}
        @endif
    @endif
@endsection