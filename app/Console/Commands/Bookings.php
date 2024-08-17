<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class Bookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:bookings {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        if($id) {
            $booking = Booking::find($id);
            if($booking) {
                $this->line($booking->toJson(JSON_PRETTY_PRINT));
            } else {
                $this->error("No Booking ID found");
            }
        }
        else {
            $booking = Booking::all();
            if($booking) {
                $this->line($booking->toJson(JSON_PRETTY_PRINT));
            } else {
                $this->error("No Bookings found");
            }
        }
    }
}
