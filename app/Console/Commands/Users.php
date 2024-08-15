<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class Users extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:users {id?}';

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
        $users = User::find($id);
        if($users){
            $this->line($users->toJson(JSON_PRETTY_PRINT));
        }
        elsE{
            $this->error('User ID not found');
        }
    }
}
