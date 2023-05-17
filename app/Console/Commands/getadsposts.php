<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ads_post;
use App\Models\campaign;
use SebastianBergmann\Environment\Console;
class getadsposts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:adsposts';

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
        $campaigns = campaign::all()->jsonSerialize();
        foreach ($campaigns as $campaign) {

         if($campaign['status']){
           $link = 'https://graph.facebook.com/v15.0/' . $campaign['campaign_id'] . '/ads?fields=id&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
            $ids = Http::get($link)->json();


            foreach ($ids['data'] as $id) {
                $link = 'https://graph.facebook.com/v15.0/' . $id['id'] . '/adcreatives?fields=effective_object_story_id,object_type&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
                $data = Http::get($link)->json();
                $link = 'https://graph.facebook.com/v15.0/' . $id['id'] . '?fields=status&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
                $status = Http::get($link)->json();
                $link = 'https://graph.facebook.com/v15.0/' . $data['data'][0]['effective_object_story_id'] . '?fields=id,message,created_time,full_picture&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
                $adpost = Http::get($link)->json();
                dump($adpost);
                if (isset($adpost['id'])) {

                    if (ads_post::where('post_id', $adpost['id'])->exists() == false) {


                        $record = new ads_post();
                        $record->post_id = $adpost["id"];
                        $record->created_time = substr($adpost['created_time'], 0, 10);
                        if (isset($adpost['message']) == true) {
                                $record->message = $adpost['message'];
                        } else {
                            $record->message = '';
                        }
                        $record->status=$status['status'];
                        $record->image_url = $adpost['full_picture'];
                        $record->campaign_id = $campaign['campaign_id'];
                        $record->ad_id = $id['id'];
                        if($data['data'][0]['object_type']=='SHARE'){
                            $record->type='PHOTO';
                        }else{
                        $record->type=$data['data'][0]['object_type'];
                        }
                        $record->save();
                        error_log('saved');
                     
                    }else{
                        ads_post::where('ad_id',$adpost['id'])->update(['image_url'=> $adpost['full_picture']]);
                        ads_post::where('ad_id',$adpost['id'])->update(['status'=> $status['status']]);

                    }
                }
             }
                // sleep(90);

            }    
        }
    }

    
}
