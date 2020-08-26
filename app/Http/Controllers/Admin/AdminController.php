<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Car;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequestForm;
use App\Mail\MOTApproval;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function carIndex()
    {
        $cars = Car::all();
        return view('admin.cars', ['cars'=>$cars]);
    }

    public function carUpdate(CarRequestForm $request, Car $id)
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
        return redirect(route('admin.car'));
    }

    public function deleteCar(Car $id)
    {
        $id->delete();
        return redirect(route('admin.car'));
    }

    public function deleteCarPhoto(Car $id)
    {
        $id->getMedia('images')->first()->delete();
        return redirect(route('admin.car'));
    }

    public function motIndex()
    {
        $cars = Car::where('request', 1)->get();
        return view('admin.mot', ['cars'=>$cars]);
    }

    public function setMot(Request $request)
    {
        if ($request['name'] == 'accept')
        {
            $car = Car::where('id', $request->id)->first();          
            $car->MOT = 1;
            $car->request = 0;
            $car->save();
            
            $user = User::where('id', $car->user_id)->first();
            Mail::to($user->email)->send(new MOTApproval('accept'));

        } else {
            $car = Car::where('id', $request->id)->first();
            $car->request = 0;
            $car->save();

            $user = User::where('id', $car->user_id)->first();
            Mail::to($user->email)->send(new MOTApproval('decline'));


            // send markdown email
        }
        
        
    }

    public function motCalendar()
    {
        $cars = Car::where('MOT', 1)->take(5)->get();
        return view('admin.calendar', ['cars'=>$cars]);
    }

    public function motSeven()
    {
        $cars = Car::where('MOT', 1)->get();
        $sevenDays = Carbon::now()->add(7, 'days');
        $count = 0;
        foreach($cars as $car)
        {
            if($sevenDays->diffInDays($car->mot)<8)
            {
                $count++;
            }
        }
        return view('admin.mot_seven', ['count'=>$count]);
    }
}
