<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Car;
use App\User;
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
        if(auth()->user()->is_agent ==0){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        return view('cars.add_car');
    }
    public function all_users()
    {
        if(auth()->user()->is_agent ==0){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        $users = User::where('is_agent', 0)->orderBy('created_at','desc')
        ->paginate(5);
        return view ('cars.all_users')->with('users', $users);
  
    }

    public function user_all_cars($id){

        $cars =  DB::table('rents')
                ->join('cars', 'rents.car_id', '=', 'cars.id')
                ->select('cars.*')
                ->where('rents.user_id', '=',  $id)
               ->paginate(5);
    
        return view('cars.user_cars')->with('cars', $cars);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->is_agent ==0){
            return redirect('/')->with('error', 'Unauthorized Page');
        }

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
        $car->agency_name = auth()->user()->name;
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
        $users =  DB::table('rents')
        ->join('users', 'rents.user_id', '=', 'users.id')
        ->select('users.*','rents.*')
        ->where('rents.car_id', '=',  $id)
       ->paginate(5);

        $car = Car::find($id);

        $data = array(
            'car' =>  $car,
            'users' => $users
        );
        return view('cars.car_users')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->is_agent ==0){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
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
        if(auth()->user()->is_agent ==0){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
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
        if(auth()->user()->is_agent ==0){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        $car = Car::find($id);

        // Check for correct user
        if(auth()->user()->id !=$car->agency){
            return redirect('/Car')->with('error', 'Unauthorized Page');
        }

        
        $car->delete();
        return redirect('/Car')->with('success', 'Car Removed');
   
    }
}
