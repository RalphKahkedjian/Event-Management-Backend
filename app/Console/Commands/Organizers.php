<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Organizer;

class Organizers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:organizers {id?}';

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
            $organizer = Organizer::find($id);
            if($organizer) {
                $this->line($organizer->toJson(JSON_PRETTY_PRINT));
            } else {
                $this->error("No organizer ID found");
            }
        }
        else {
            $organizer = Organizer::all();
            if(!$organizer->isEmpty()) {
                $this->line($organizer->toJson(JSON_PRETTY_PRINT));
            } else {
                $this->error("No organizer found");
            }
        }
    }
}
