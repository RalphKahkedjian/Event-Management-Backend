<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendee;

class Attendees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:attendees {id?}';

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
            $attendee = Attendee::find($id);
            if($attendee) {
                $this->line($attendee->toJson(JSON_PRETTY_PRINT));
            } else {
                $this->error("No attendee ID found");
            }
        }
        else {
            $attendee = Attendee::all();
            if($attendee->isEmpty()) {
                $this->error("No attendee found");
            } else {
                $this->line($attendee->toJson(JSON_PRETTY_PRINT));
            }
        }
    }
}
