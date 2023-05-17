<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\campaign;
use App\Models\adset;
use App\Models\page;
use App\Models\ads_post;
use App\Models\insight;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class getinsights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:insights';

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
        $posts = DB::table('ads_posts')
        ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
        // ->where('campaigns.status', 'active')
        // ->select('ads_posts.ad_id ')
        ->get();
        foreach($posts as $post ){
            $link = 'https://graph.facebook.com/v15.0/'.$post->ad_id.'/insights?fields=reach,impressions,spend,clicks,cpc,cpm,cpp,ctr,frequency&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
            $insights = Http::get($link)->json();
            if(isset($insights['data'][0])==true){
            $insights=$insights["data"][0];
            $record = new insight();
            $record->ad_id=$post->ad_id;
            $record->clicks=$insights['clicks'];
            $record->reach=$insights['reach'];
            // $record->cpc=$insights['cpc'];
            $record->cpm=$insights['cpm'];
            $record->cpp=$insights['cpp'];
            $record->ctr=$insights['ctr'];
            $record->frequency=$insights['frequency'];
            $record->spend=$insights['spend'];
            $record->impressions=$insights['impressions'];
            $record->save();
            // dump($record);
            // dump($insights);
            // dump('saved');
            }
        }

    }
}
