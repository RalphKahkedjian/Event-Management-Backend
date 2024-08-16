<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;

class Tickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tickets {id?}';

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
        if($id){
            $ticket = Ticket::find($id);
            if($ticket) {
                $this->line($ticket->toJson(JSON_PRETTY_PRINT));
            } else {
                $this->error("No ticket ID found");
            }
        }
        else {
            $ticket = Ticket::all();
            if(!$ticket->isEmpty()) {
                $this->line($ticket->toJson(JSON_PRETTY_PRINT));
            } else {
                $this->error("No Tickets Found");
            }
        }
    }
}
