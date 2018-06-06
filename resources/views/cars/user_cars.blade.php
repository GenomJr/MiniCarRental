@extends('layouts.app')

@section('content')
    <h1>User Cars</h1>
    @if(count($cars) > 0)
        @foreach($cars as $car)
            <div class="well">
                <div class="row">
                    
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="#">{{$car->brand}} {{$car->model}}</a></h3>
                        <h6> The Car color is {{$car->color}} </h6>
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
        {{$cars->links()}}
    @else
        <p>No Cars found</p>
    @endif
@endsection