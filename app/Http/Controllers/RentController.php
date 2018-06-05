<?php

namespace App\Http\Controllers;

use App\Rent;
use App\Car;
use App\User;
use Illuminate\Http\Request;
use DB;

class RentController extends Controller
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
        $id = auth()->user()->id;
        $cars =  DB::table('rents')
                ->join('cars', 'rents.car_id', '=', 'cars.id')
                ->select('cars.*')
                ->where('rents.user_id', '=',  $id)
                ->get();
    
        return view('rents.user_cars')->with('cars', $cars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function all_users()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        // Create car
        $rent = new Rent;
        $rent->user_id =  auth()->user()->id;
        $rent->car_id = $request->input('car_id');
        $rent->rent_start =  $request->input('rent_start');
        $rent->rent_end =  $request->input('rent_end');
       
        $rent->save();

        return redirect('/Rent')->with('success', 'Car Rented');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);

        // Check for correct user
        if(auth()->user()->id == $car->agency){
            return redirect('/Rent')->with('error', 'Unauthorized Page');
        }

        return view('rents.user_history')->with('car', $car);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rent  $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = auth()->user()->id;
        $rent = Rent::where('car_id', $id) 
                ->where( 'user_id','=', $user_id)
                ->first(); 


        // Check for correct user
        if(auth()->user()->id != $rent->user_id){
            return redirect('/Rent')->with('error', 'Unauthorized Page');
        }

        
        $rent->delete();
        return redirect('/Rent')->with('success', 'Car Removed');
    }
}
