<?php

namespace App\Console\Commands;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\campaign;
use Illuminate\Support\Facades\Http;
use App\Models\page;
class getcampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:campaigns';

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
        $pages = page::all();
        foreach ($pages as $page) {

            dump($page['page_id']);

            set_time_limit(0);
            $date_post_toget = Carbon::now();
            $date_post_toget->subMonths(1);
            $date_post_toget = $date_post_toget->format('Y-m-d');

            $link = "https://graph.facebook.com/v16.0/" . $page['page_id'] . "/campaigns?fields=name,start_time,stop_time,status,objective&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB";
            $try = true;
            while ($try) {
                $campaigns = Http::get($link)->json();
                $paging = $campaigns['paging'];
                $campaigns = $campaigns['data'];
                foreach ($campaigns as $campaign) {
                    if (campaign::where('campaign_id', $campaign['id'])->exists() == false) {
                        if (substr($campaign["start_time"], 0, 10) >= $date_post_toget) {
                            $record = new campaign();
                            $record->campaign_id = $campaign['id'];
                            $record->name = $campaign['name'];
                            $record->start_time = substr($campaign['start_time'], 0, 10);
                            if (isset($campaign['stop_time'])) {
                                $record->stop_time = substr($campaign['stop_time'], 0, 10);
                            } else {
                                $record->stop_time = "-";
                            }
                            $record->status = $campaign['status'];
                            $record->objective = $campaign['objective'];
                            $record->page_id = $page['page_id'];
                            $record->save();
                        } else {
                            $try = false;
                            break;
                        }
                    }else{
                        campaign::where('campaign_id', $campaign['id'])->update(['status'=> $campaign['status']]);
                    }
                        
                    

                    if (isset($paging['next']) == false) {
                        $try = false;

                    } else {
                        $link = $paging["next"];
                    }

                }
            }
        }
    }
}
