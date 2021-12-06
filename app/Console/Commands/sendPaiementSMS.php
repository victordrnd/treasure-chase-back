<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Panier;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SMSFactor\Laravel\Facade\Message;

class sendPaiementSMS extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notif';

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
        $paniers = Panier::where('status_id', 4)->get();
        $i = 0;
        foreach ($paniers as $panier) {
            try {
                Message::send([
                    'to' => $panier->user->phone,
                    'text' => "Black Pint'hère\nL'heure du deuxième paiement de ta SkiWeek a sonné ! Connectes toi vite sur ton compte BP !\n https://black-pinthere.fr",
                    'pushtype' => 'alert',
                    'sender' => 'BDE CPE'
                ]);
            } catch (\Exception $e) {
                error_log(sprintf("\033[31m%s\033[0m", "ERROR - " . strval($i) . " " . $panier->user->firstname . " " . $panier->user->lastname . " " . $e->getMessage()));
            }
            error_log('Sending SMS to ' . $panier->user->lastname . " " . $panier->user->firstname . "  : [" . $panier->user->phone . "]");
            $i++;
        }
        return 0;
    }
}
