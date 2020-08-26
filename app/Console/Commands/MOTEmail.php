<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Car;
use App\User;

use App\Notifications\CarNotification;
use App\Notifications\UserDateNotification;

class MOTEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mot:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cars = Car::where('MOT', 1)->get();
        $seven_days = Carbon::now()->add(7, 'days');
        foreach($cars as $car){
            sleep(2);
            if ($seven_days->diffInDays($car->mot)<8)
            {
                error_log('hit 1');
                if($car->notifications->first() == null){
                    error_log('hit 2');
                    $car->notify(new CarNotification($car));
                    $user = User::where('id', $car->user_id)->first();
                    $user->notify(new UserDateNotification($car->mot_time));
                    
                };                


            } 
        } 
    }
}
