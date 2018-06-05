<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Car;
use DB;
class CarsController extends Controller
{

  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       if(auth()->user()->is_agent ==1){
        $id = auth()->user()->id;
        $cars =  Car::where('agency', $id) 
                ->orderBy('created_at','desc')
                ->paginate(10);
        return view('cars.agent_cars')->with('cars', $cars);
       }
       else{
        $cars =  Car::orderBy('created_at','desc')
                ->paginate(10);
        return view('cars.agent_cars')->with('cars', $cars);
    }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars.add_car');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => 'required',
            'brand' => 'required',
            'color' => 'required'
        ]);
       
        // Create car
        $car = new car;
        $car->model = $request->input('model');
        $car->brand = $request->input('brand');
        $car->color = $request->input('color');
        $car->isava = 1;
        $car->rent_start = '1970-01-01';
        $car->rent_end = '2020-01-01';
        $car->agency = auth()->user()->id;
       
        $car->save();

        return redirect('/Car')->with('success', 'car Added');
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);
        return view('cars.car_users')->with('car', $car);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::find($id);

        // Check for correct user
        if(auth()->user()->id != $car->agency){
            return redirect('/Car')->with('error', 'Unauthorized Page');
        }

        return view('cars.edit_car')->with('car', $car);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'model' => 'required',
            'brand' => 'required',
            'color' => 'required'
        ]);
       
        // Create car
        $car = car::find($id);
        $car->model = $request->input('model');
        $car->brand = $request->input('brand');
        $car->color = $request->input('color');
        $car->isava = 1;
        $car->rent_start = '1970-01-01';
        $car->rent_end = '2020-01-01';
        $car->agency = auth()->user()->id;
       
        $car->save();

        return redirect('/Car')->with('success', 'car Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);

        // Check for correct user
        if(auth()->user()->id !=$car->agency){
            return redirect('/Car')->with('error', 'Unauthorized Page');
        }

        
        $car->delete();
        return redirect('/Car')->with('success', 'Car Removed');
   
    }
}
