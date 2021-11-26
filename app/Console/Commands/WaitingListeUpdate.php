<?php

namespace App\Console\Commands;

use App\Models\Panier;
use App\Models\Status;
use App\Models\User;
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
        $panier_waiting_paiement = User::whereHas('panier', function($q){
            return $q->where('status_id', 3);
        })->pluck('panier_id');

        $limit_to_move = count($panier_waiting_paiement);//350 - (317-count($panier_waiting_paiement));

        $paniers_to_move = Panier::where('status_id', 2)->orderBy('completed_at', 'asc')->limit($limit_to_move)->pluck('id');

        Panier::whereIn('id', $panier_waiting_paiement)->update([
            'status_id' => 2,
            'completed_at' => Carbon::now()->toDateTimeString()
        ]);

       Panier::whereIn('id', $paniers_to_move)->update([
           'status_id' => 3
       ]);

        $to_notif = Panier::whereIn("id", $paniers_to_move)->with('user')->get();
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
