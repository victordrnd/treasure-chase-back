<?php

namespace App\Console\Commands;

use App\Models\FoodPack;
use App\Models\Panier;
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

        // $paniers = Panier::where('status_id', 1)->get();
        // $i = 0;
        // foreach ($paniers as $panier) {
        //     if($panier->user->phone != "0"){
        //         try {
        //             Message::send([
        //                 'to' => $panier->user->phone,
        //                 'text' => "Black Pint'hère\nLe paiement de ton panier SkiWeek est disponible à 22h ce soir ! Dépêches toi avant qu'il ne reste plus de place !\n https://black-pinthere.fr",
        //                 'delay' => "2021-11-08 21:30:00",
        //                 'pushtype' => 'alert',
        //                 'sender' => 'BDE CPE'
        //             ]);
        //         } catch (\Exception $e) {
        //             error_log(sprintf("\033[31m%s\033[0m", "ERROR - ". strval($i)." ". $panier->user->firstname . " " . $panier->user->lastname." ".$e->getMessage()));
        //         }
        //         error_log('Sending SMS to ' . $panier->user->lastname . " " . $panier->user->firstname . "  : [" . $panier->user->phone . "]");
        //         $i++;
        //     }
        // }
        // return 0;
    }
}


