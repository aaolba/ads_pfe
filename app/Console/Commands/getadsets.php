<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\adset;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\campaign;
class getadsets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:adsets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        set_time_limit(0);
        $date_post_toget = Carbon::now();
        $date_post_toget->subMonths(1);
        $date_post_toget = $date_post_toget->format('Y-m-d');

        $Active_campaigns= campaign::where('status','active')->select('campaign_id')->get();
       
        foreach ($Active_campaigns as $Active_campaign) {
            $link = 'https://graph.facebook.com/v16.0/' . $Active_campaign['campaign_id'] . '/adsets?fields=name,status,start_time,end_time&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
            $adsets = Http::get($link)->json();
            if (isset($adsets['data']) == true) {
                $adsets = $adsets['data'];
                foreach ($adsets as $adset) {
                    if (adset::where('adset_id', $adset['id'])->exists() == false) {
                        $record = new adset();
                        $record->adset_id = $adset['id'];
                        $record->name = $adset['name'];
                        if (isset($adset['end_time'])) {
                            $record->end_time = substr($adset['end_time'],0,10);
                        } else {
                            $record->end_time = "-";
                        }
                        $record->start_time = substr($adset['start_time'],0,10);
                        $record->status = $adset['status'];
                        $record->campaign_id = $Active_campaign['campaign_id'];
                        $record->save();
                    }
                    sleep(10); 
                }

            }

        }
    }
}
