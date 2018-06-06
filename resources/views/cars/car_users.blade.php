@extends('layouts.app')

@section('content')
    <a href="/Car" class="btn btn-default">Go Back</a>
    <h1>{{$car->brand}} {{$car->model}}</h1>
     <br><br>
     <small>Written on {{$car->created_at}} 
             
        


        <h1>All Renters Users</h1>
    @if(count($users) > 0)
        @foreach($users as $user)
            <div class="well">
                <div class="row">
                    
                    <div class="col-md-8 col-sm-8"> 
                        <h3><a href="/user/{{$user->id}}">{{$user->name}} </a></h3>
                        <h5>User mobile : {{$user->mobile}}</h5>
                        <h5>User e-mail : {{$user->email}}</h5>
                        <small>Joined at {{$user->created_at}} </small>
                    </div>
                </div>
            </div>
        @endforeach
        {{$users->links()}}
    @else
        <p>No User found</p>
    @endif




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
            {{Form::selectRange('rent_start_month', 1, 12, '', ['class' => 'form-control', 'placeholder' => 'month'])}}
            {{Form::label('rent_start_day', 'Rent_start_day')}}
            {{Form::selectRange('rent_start_day',1, 30, '', ['class' => 'form-control',  'placeholder' => 'day'])}}
            
        </div>

        <div class="form-group">
            {{Form::label('rent_end_month', 'Rent_end_month')}}
            {{Form::selectRange('rent_end_month',1, 12, '', ['class' => 'form-control', 'placeholder' => 'month'])}}
            {{Form::label('rent_end_day', 'Rent_end_day')}}
            {{Form::selectRange('rent_end_day',1, 30, '', ['class' => 'form-control', 'placeholder' => 'day'])}}
            {{Form::label('rent_year', 'Rent_year')}}
            {{Form::selectRange('rent_year',2018, 2050, '', ['class' => 'form-control', 'placeholder' => 'year'])}}
              
        </div>
        
        {{Form::hidden('car_id', $car->id, ['class' => 'form-control'])}}
        {{Form::submit('Rent', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
          <br><br>
          <br><br>
          <br><br>
          <br><br>
        @endif
    @endif
@endsection