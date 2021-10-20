<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SMSFactor\Laravel\Facade\Message;

class SendSMS extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:sms';

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
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $users = User::whereNull('password')->get();
        foreach ($users as $user) {
            $user->token = Str::random(18);
            $user->save();

            try {
                // Message::send([
                //     'to' => $user->phone,
                //     'text' => "Black Pint'hère\nL'heure des inscriptions à la SkiWeek a sonné ! Récupères ton compte ici :\nhttps://black-pinthere.fr/password-reset/".$user->token,
                //     'pushtype' => 'alert',
                //     'sender' => 'BDE CPE'
                // ]);
            } catch (\Exception $e) {
                error_log(sprintf("\033[31m%s\033[0m", "ERROR : https://black-pinthere.fr/password-reset/" . $user->token . "   " . $user->firstname . " " . $user->lastname." ".$e->getMessage()));
            }
            error_log('Sending SMS to ' . $user->lastname . " " . $user->firstname . "  : [" . $user->phone . "] https://black-pinthere.fr/password-reset/" . $user->token);
        }
        return 0;
    }
}
