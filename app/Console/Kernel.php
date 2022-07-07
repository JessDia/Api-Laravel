<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;
use Mail;
use App\Mail\SendMail;


class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $stockData = [
                'title' => 'Correo de cafeteriakonecta@gmail.com',
                'body' => 'El stock de los productos esta a punto de agotarse, se recomienda surtir la tienda.'
            ];
    
            Mail::to('inforomacionstock@gmail.com')->send(new SendMail ($stockData));
            
        })->everyMinute()->when(function () {
    
            $productos = Producto::where('stock','<=','10')->get();
            
            if(count($productos) == 0){
                return false;
            }
            return true;
        });;
    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
