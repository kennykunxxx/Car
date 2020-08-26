<?php

namespace App\Http\Controllers\Car;

use App\Car;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequestForm;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $cars = Car::where('user_id', $user_id)->get();
        return view('car.index', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarRequestForm $request)
    {  

        $validatedData = $request->except('image');
        $validatedData['user_id'] = Auth::user()->id;
        $car = Car::create($validatedData);
        if($request->hasFile('image'))
            {
            foreach($request->files as $image)
            {
                $car->addMedia($image)->toMediaCollection('images');
            }
        
            }

        return redirect(route('car.index'));
        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $id)
    {
        return view('car.edit', ['car'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(CarRequestForm $request, Car $id)
    {

        $validatedData = $request->except('image');
        $id -> update($validatedData);

        if($request->hasFile('image'))
        {
            foreach($request->files as $image)
            {
                if ($id->getMedia('images')->first())
                {
                    $id->getMedia('images')->first()->delete();
                }
                $id->addMedia($image)->toMediaCollection('images');
            }
        }
        return redirect(route('car.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $id)
    {
        $id->delete();
        return redirect(route('car.index'));
        
    }

    public function deleteCarPhoto(Car $id)
    {
        $id->getMedia('images')->first()->delete();
        return redirect()->back();
    }

    public function createDate(Car $id)
    {
        return view('car.mot_create', ['id'=>$id]);
    }

    public function storeDate(Request $request, Car $id)
    {
        $string = $request->mot." ".$request->time;
        $time = Carbon::createFromFormat('Y-m-d H:i', $string, 'Europe/London')->format('Y-m-d H:i:s');
        $id->mot_time = $time;
        $id->request = 1;
        $id->save();
        return redirect(route('car.index'));
    }


}
