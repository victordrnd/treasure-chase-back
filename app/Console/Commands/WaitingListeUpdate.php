<?php

namespace App\Console\Commands;

use App\Models\Panier;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;
use SMSFactor\Laravel\Facade\Message;

class WaitingListeUpdate extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waiting_liste:update';

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
        $waiting_paiement_status_id = Status::where('code', 'waiting_paiement')->first()->id;
        $waiting_list_status_id = Status::where('code', 'waiting_list')->first()->id;
        $waiting_paiement_panier = Panier::where('status_id', $waiting_paiement_status_id)->pluck("id");

        error_log("Mise à jour de la liste d'attente : " . count($waiting_paiement_panier) . " Mise à jour");
        //Mise à jour de liste d'attente vers Paiement
        $waiting_liste_panier = Panier::where('status_id', $waiting_list_status_id)->orderBy('completed_at', 'asc')->limit(count($waiting_paiement_panier))->pluck('id');
        Panier::whereIn('id', $waiting_liste_panier)->update([
            'status_id' => $waiting_paiement_status_id
        ]);


        //Mise à jour de paiement à liste d'attente + reset
        Panier::whereIn('id', $waiting_paiement_panier)->update([
            'status_id' => $waiting_list_status_id,
            'completed_at' => Carbon::now()->toDateTimeString()
        ]);

        //Envoie du sms
        $to_notif = Panier::whereIn("id", $waiting_liste_panier)->with('user')->get();
        foreach ($to_notif as $panier) {
            try {
                Message::send([
                    'to' => $panier->user->phone,
                    'text' => "Black Pinthère\nTu n'es plus en liste d'attente pour la SkiWeek, tu as maintenant 48h pour procéder au paiement.\nConnectes toi à ton compte pour en savoir plus !",
                    'pushtype' => 'alert',
                    'sender' => 'BDE CPE'
                ]);
                error_log("Envoie d'une notification à : ". $panier->user->firstname . " " . $panier->user->lastname);
            } catch (\Exception $e) {
                error_log(sprintf("\033[31m%s\033[0m", "ERROR : " . $panier->user['firstname'] . " " . $panier->user['lastname'] . " " . $e->getMessage()));
            }
        }
        return 0;
    }
}
