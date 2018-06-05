@extends('layouts.app')

@section('content')
    <h1>My History</h1>
    @if(count($cars) > 0)
        @foreach($cars as $car)
            <div class="well">
                <div class="row">
                    
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="/Rent/{{$car->id}}">{{$car->brand}} {{$car->model}}</a></h3>
                        <small>Written on {{$car->created_at}} 
                            
                            @if($car->isava ==1)

                            <br>
                            the car is available

                            @elseif($car->isava ==0)
                            <br>
                            the car is busy
                            @endif
                            </small>
                    </div>
                </div>
            </div>
        @endforeach
       
    @else
        <p>No history found</p>
    @endif
@endsection