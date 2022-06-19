<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Mail\RenewPlansReminder;
use App\Models\User;
use Carbon\Carbon;

class RenewPlansReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'email:renew';

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
        $users = User::where('plan_id' , '>' , 1)->get();
        foreach($users as $user){  
            $user->expire = Carbon::now()->diffInDays(Carbon::parse($user->plan_end_date));
            if( $user->expire < 3 && $user->expire >= 0){
                Mail::to('mk.farhat@hotmail.com')->send(new RenewPlansReminder($user));
            }
            sleep(5);
        }
        //$user = User::where('id', 1)->first(); 
        return 0;
    }
}
