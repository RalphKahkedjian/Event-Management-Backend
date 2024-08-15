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
      if($id){
        $user = User::find($id);
        if($user){
           $this->line($user->toJson(JSON_PRETTY_PRINT));
        }
        else{
            $this->error("No User ID found");
        }
      }
      else{
        $user = User::all();
        if(!$user->isEmpty()){
            $this->line($user->toJson(JSON_PRETTY_PRINT));
        }
        else{
            $this->error("No Users Found");
        }
      }
    }
}
