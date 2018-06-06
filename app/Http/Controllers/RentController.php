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
        if(auth()->user() == null){
            return redirect('/')->with('error', 'Unauthorized Page');

        }
        if(auth()->user()->is_agent ==1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }

    

        $id = auth()->user()->id;
        $cars =  DB::table('rents')
                ->join('cars', 'rents.car_id', '=', 'cars.id')
                ->select('cars.*')
                ->where('rents.user_id', '=',  $id)
                ->where('rents.is_user_delete_history', '=',  true)
                ->paginate(5);
    
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

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user() == null){
            return redirect('/')->with('error', 'Unauthorized Page');

        }
        if(auth()->user()->is_agent ==1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }

         $rent_start_month=$request->input('rent_start_month');
         $rent_start_day=$request->input('rent_start_day');
        $this->validate($request, [
            'rent_start_month' => 'required',
            'rent_end_month' => 'required|gte:'.$rent_start_month,
            'rent_start_day' => 'required',
            'rent_end_day' => 'required|gte:'.$rent_start_day
        ],$messages = [ 'gte' => 'The End rent date must be greater or equal the Start rent date.',
        ]
        );

        // Create Rent
        $is_ava_rent_case1 =  Rent::where('car_id',$request->input('car_id'))
                    ->where('rent_start','>=',$request->input('rent_year').'-'.$request->input('rent_start_month')
                    .'-'.$request->input('rent_start_day'))
                    ->where('rent_start','<=',$request->input('rent_year') .'-'.$request->input('rent_end_month')
                    .'-'.$request->input('rent_end_day'))
                    ->first();


            $is_ava_rent_case2 =  Rent::where('car_id',$request->input('car_id'))
            ->where('rent_start','>=',$request->input('rent_year').'-'.$request->input('rent_start_month')
            .'-'.$request->input('rent_start_day'))
                    ->where('rent_start','<=',$request->input('rent_year') .'-'.$request->input('rent_end_month')
                .'-'.$request->input('rent_end_day'))
                    ->first();

              $is_ava_rent_case3 =  Rent::where('car_id',$request->input('car_id'))
              ->where('rent_start','<=',$request->input('rent_year').'-'.$request->input('rent_start_month')
              .'-'.$request->input('rent_start_day'))
              ->where('rent_start','<=',$request->input('rent_year') .'-'.$request->input('rent_end_month')
              .'-'.$request->input('rent_end_day'))
              ->where('rent_end','>=',$request->input('rent_year') .'-'.$request->input('rent_end_month')
              .'-'.$request->input('rent_end_day'))
              ->first();


              
        $rent = new Rent;
        $rent->user_id =  auth()->user()->id;
        $rent->car_id = $request->input('car_id');
        $rent->rent_start = $request->input('rent_year').'-'.$request->input('rent_start_month')
        .'-'.$request->input('rent_start_day');
        
        $rent->rent_end =$request->input('rent_year') .'-'.$request->input('rent_end_month')
        .'-'.$request->input('rent_end_day');
      
        
        if($is_ava_rent_case1.$is_ava_rent_case2.$is_ava_rent_case3 ==""){
            $rent->save();
            return redirect('/Car'.'/'.$request->input('car_id'))->with('success', 'Car Rented');
        }
        return redirect('/Car'.'/'.$request->input('car_id'))->with('error', 'Car not available at this period');

  
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
        if(auth()->user() == null){
            return redirect('/')->with('error', 'Unauthorized Page');

        }
        if(auth()->user()->is_agent ==1){
            return redirect('/')->with('error', 'Unauthorized Page');
        }
        $user_id = auth()->user()->id;
        $rent = Rent::where('car_id', $id) 
                ->where( 'user_id','=', $user_id)
                ->first(); 


        // Check for correct user
        if(auth()->user()->id != $rent->user_id){
            return redirect('/Rent')->with('error', 'Unauthorized Page');
        }

        $rent->is_user_delete_history = false;
        $rent->save();
        return redirect('/Rent')->with('success', 'Car Removed');
    }
}
