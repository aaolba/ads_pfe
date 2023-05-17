<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\campaign;
use App\Models\adset;
use App\Models\page;
use App\Models\ads_post;
use App\Models\insight;
use App\Models\posts_concurrent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Psy\VersionUpdater\Downloader;

class DBController extends Controller
{

    public function getCampaign()
    {
        $date_post_toget = Carbon::now();
        $date_post_toget->subMonths(1);
        $date_post_toget = $date_post_toget->format('Y-m-d');

        $link = "https://graph.facebook.com/v16.0/act_750139138839387/campaigns?fields=name,start_time,stop_time,status,objective&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB";
        $try = true;
        while ($try) {
            $campaigns = Http::get($link)->json();
            $paging = $campaigns['paging'];
            $campaigns = $campaigns['data'];
            foreach ($campaigns as $campaign) {
                if (substr($campaign["start_time"], 0, 10) >= $date_post_toget) {
                    $record = new campaign();
                    $record->campaign_id = $campaign['id'];
                    $record->name = $campaign['name'];
                    $record->start_time = substr($campaign['start_time'],0,10);
                    if (isset($campaign['stop_time'])) {
                        $record->stop_time =substr( $campaign['stop_time'],0,10);
                    } else {
                        $record->stop_time = "-";
                    }
                    $record->status = $campaign['status'];
                    $record->objective = $campaign['objective'];
                    $record->page_id="act_750139138839387";
                    $record->save();
                    dump($campaign);
                } else {
                    $try = false;
                    break;
                }

                dump($campaign);
            }
            if (isset($paging['next']) == false) {
                $try = false;

            } else {
                $link = $paging["next"];
            }

        }
    }


    // public function getAdsets()
    // {
    //     set_time_limit(0);
    //     $campaigns = campaign::all()->jsonSerialize();
    //     foreach ($campaigns as $campaign) {
    //         $link = 'https://graph.facebook.com/v16.0/' . $campaign['campaign_id'] . '/adsets?fields=name,status,start_time,end_time&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
    //         $adsets = Http::get($link)->json();
    //         dump($adsets);
    //         if (isset($adsets['data']) == true) {
    //             $adsets = $adsets['data'];
    //             foreach ($adsets as $adset) {
    //                 $record = new adset();
    //                 $record->adset_id = $adset['id'];
    //                 $record->name = $adset['name'];
    //                 if (isset($adset['end_time'])) {
    //                     $record->end_time = substr($adset['end_time'],0,10);
    //                 } else {
    //                     $record->end_time = "-";
    //                 }
    //                 $record->start_time = substr($adset['start_time'],0,10);
    //                 $record->status = $adset['status'];
    //                 $record->campaign_id = $campaign['campaign_id'];
    //                 $record->save();
    //             }

    //         }


    //         sleep(10);

    //     }
    // }



    public function getAds()
    {
        set_time_limit(0);
        $campaigns = campaign::all()->jsonSerialize();
        foreach ($campaigns as $campaign) {

           

            $link = 'https://graph.facebook.com/v15.0/' . $campaign['campaign_id'] . '/ads?fields=id&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
            $ids = Http::get($link)->json();
            

            foreach ($ids['data'] as $id) {
                $link = 'https://graph.facebook.com/v15.0/' . $id['id'] . '/adcreatives?fields=effective_object_story_id,object_type&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
                $data = Http::get($link)->json();
                
                $link = 'https://graph.facebook.com/v15.0/' . $id['id'] . '?fields=status&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
                $status = Http::get($link)->json();
                // dump($status['status']);
                $link = 'https://graph.facebook.com/v15.0/' . $data['data'][0]['effective_object_story_id'] . '?fields=id,message,created_time,full_picture&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
                $adpost = Http::get($link)->json();
                // dump($adpost);
            

                    if (ads_post::where('post_id', $adpost['id'])->exists() == false) {


                        $record = new ads_post();
                        $record->post_id = $adpost["id"];
                        $record->created_time = substr($adpost['created_time'], 0, 10);
                        if (isset($adpost['message']) == true) {
                                $record->message = $adpost['message'];
                        } else {
                            $record->message = '';
                        }
                        $record->image_url = $adpost['full_picture'];
                        $record->campaign_id = $campaign['campaign_id'];
                        $record->ad_id = $id['id'];
                        if($data['data'][0]['object_type']=='SHARE'){
                            $record->type='PHOTO';
                        }else{
                        $record->type=$data['data'][0]['object_type'];
                        }
                        $record->status=$status['status'];
                        // if (Str::contains($campaign['name'], 'Instagram ', false)) {
                        //     $record->platforme='instagram';
                        // }else{
                        //     $record->platforme='facebook';
                        // }
                        $record->save();
                        dump('saved');
                     
                    }

                // sleep(60);

            } 
        
        

        }
    }



    


    public function tunisie_Telecome(){
        $link = 'https://api.apify.com/v2/datasets/045neDgIRJtfr50xs/items?clean=true&format=json';
        $posts = Http::get($link)->json();
        foreach($posts as $post){
            $record = new posts_concurrent();
            $record->post_id=$post['adArchiveID'];
            $record->created_time=substr($post['startDateFormatted'],0,10);
            $record->message=strip_tags(html_entity_decode($post['snapshot']['body']['markup']['__html']));
            if(isset($post['snapshot']['images'][0]['original_image_url'])){
                $record->image_url=$post['snapshot']['images'][0]['original_image_url'];
                $record->type='PHOTO';
            }else if(isset($post['snapshot']['cards'][0]['original_image_url'])){
                $record->image_url=$post['snapshot']['cards'][0]['original_image_url'];
                $record->type='PHOTO';
            }else{
                $record->image_url=$post['snapshot']['videos'][0]['video_preview_image_url'];
                $record->type='VIDEO';
            }
            if($post["isActive"] == true){
                $record->status='ACTIVE';
            }else{
                $record->status='PAUSED';
            }
            $record->page_concurrent_id=$post['pageID'];
            // $platforme='';
            // foreach($post["publisherPlatform"] as $plat){
            //     $platforme=$platforme.str($plat).'-';
            // }
            // $platforme=substr($platforme,0,-1);
            // $record->platforme=$platforme;
            dump($record);
            $record->save();

        }

    }

    public function ooredoo(){
        $link = 'https://api.apify.com/v2/datasets/SdlFtvRgrJ3APRRA2/items?clean=true&format=json';
        $posts = Http::get($link)->json();
            foreach($posts as $post){
            $record = new posts_concurrent();
            $record->post_id=$post['adArchiveID'];
            $record->created_time=substr($post['startDateFormatted'],0,10);
            $record->message=strip_tags(html_entity_decode($post['snapshot']['body']['markup']['__html']));
            if(isset($post['snapshot']['images'][0]['original_image_url'])){
                $record->image_url=$post['snapshot']['images'][0]['original_image_url'];
                $record->type='PHOTO';
            }else if(isset($post['snapshot']['cards'][0]['original_image_url'])){
                $record->image_url=$post['snapshot']['cards'][0]['original_image_url'];
                $record->type='PHOTO';
            }else{
                $record->image_url=$post['snapshot']['videos'][0]['video_preview_image_url'];
                $record->type='VIDEO';
            }
            if($post["isActive"] == true){
                $record->status='ACTIVE';
            }else{
                $record->status='PAUSED';
            }
            $record->page_concurrent_id=$post['pageID'];
            // $platforme='';
            // foreach($post["publisherPlatform"] as $plat){
            //     $platforme=$platforme.str($plat).'-';
            // }
            // $platforme=substr($platforme,0,-1);
            // $record->platforme=$platforme;
            dump($record);
            $record->save();
        }

    }


               
}

