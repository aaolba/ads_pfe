<?php

namespace App\Http\Controllers;

use App\Models\insight;
use App\Models\posts_concurrent;
use App\Models\post_planifider;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ads_post;
use App\Models\campaign;
use App\Models\adset;
use App\Models\page;
use App\Models\pages_concurrent;
use Illuminate\Support\Facades\DB;

class getDataController extends Controller
{




    public function getAllcampaigns(Request $request)
    {

        $start_date = $request->input('start');
        $end_date = $request->input('end');
        $currentPage = $request->input('currentPage');
        $status = $request->input('status');
        $page_name = $request->input('page_name');

        $page_id = DB::table('pages')
            ->where('page_name', $page_name)
            ->value('page_id');
        // dump($page_id);

        if ($end_date == "" && $status == "") {
            $campaigns = DB::table('campaigns')
                ->where('page_id', $page_id)
                ->get();
            $campaignsNumber = campaign::count();
        } else if ($status != "" && $end_date == "") {
            $campaigns = campaign::where('status', $status)
                ->where('page_id', $page_id)
                ->get()->jsonSerialize();
            $campaignsNumber = count($campaigns);
        } else if ($status == "" && $end_date != "") {
            $campaigns = campaign::whereBetween('start_time', [$start_date, $end_date])
                ->where('page_id', $page_id)
                ->get()->jsonSerialize();
            $campaignsNumber = count($campaigns);
        } else {
            $campaigns = campaign::whereBetween('start_time', [$start_date, $end_date])
                ->where('status', $status)
                ->where('page_id', $page_id)
                ->get()->jsonSerialize();
            $campaignsNumber = count($campaigns);
        }

        return [collect($campaigns)->skip(16 * ($currentPage - 1))->take(16)->toArray(), $campaignsNumber];
    }


    public function getfilteredPostes(Request $request)
    {
        $start_date = $request->input('start');
        $end_date = $request->input('end');
        $currentPage = $request->input('currentPage');
        $page_name = $request->input('page_name');
        $selectedpageid = $request->input('selectedpageid');
        $mediatype = $request->input('mediatype');
        // $selectedpageid='117627008288878';

        // $mediatype='video';
        // $page_name='orange';
        // $start_date='';
        // $end_date='';
        // $selectedpageid='';


        if($selectedpageid == ''){

            $page_id = DB::table('pages')->select('page_id')->where('page_name',$page_name)->get()->jsonSerialize();
            $page_id=$page_id[0]->page_id;
                if($end_date == "" && $mediatype == ""){

                    $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.ad_id','ads_posts.created_time','ads_posts.message','ads_posts.image_url','ads_posts.type','ads_posts.status', 'pages.page_name', 'pages.page_image_url')
                    ->where('pages.page_id', '=', $page_id);



                    $posts1 = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.ad_id','posts_concurrents.created_time','posts_concurrents.message','posts_concurrents.image_url','posts_concurrents.type','posts_concurrents.status', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('pages.page_id', '=', $page_id);

                    $combinedQuery = $posts->union($posts1);
                    $posts=$combinedQuery->get()->jsonSerialize();
                    // dump($posts);
                }else if($end_date != "" && $mediatype == ""){
                    $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.ad_id','ads_posts.created_time','ads_posts.message','ads_posts.image_url','ads_posts.type','ads_posts.status', 'pages.page_name', 'pages.page_image_url')
                    ->where('pages.page_id', '=', $page_id)
                    ->whereBetween('created_time', [$start_date, $end_date]);



                    $posts1 = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.ad_id','posts_concurrents.created_time','posts_concurrents.message','posts_concurrents.image_url','posts_concurrents.type','posts_concurrents.status', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('pages.page_id', '=', $page_id)
                    ->whereBetween('created_time', [$start_date, $end_date]);

                    $combinedQuery = $posts->union($posts1);
                    $posts=$combinedQuery->get()->jsonSerialize();
                    
                }else if($end_date != "" && $mediatype != ""){

                    $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.ad_id','ads_posts.created_time','ads_posts.message','ads_posts.image_url','ads_posts.type','ads_posts.status', 'pages.page_name', 'pages.page_image_url')
                    ->where('pages.page_id', '=', $page_id)
                    ->whereBetween('created_time', [$start_date, $end_date])
                    ->where('ads_posts.type', '=', $mediatype);


                    $posts1 = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.ad_id','posts_concurrents.created_time','posts_concurrents.message','posts_concurrents.image_url','posts_concurrents.type','posts_concurrents.status', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('pages.page_id', '=', $page_id)
                    ->whereBetween('created_time', [$start_date, $end_date])
                    ->where('posts_concurrents.type', '=', $mediatype);

                    $combinedQuery = $posts->union($posts1);
                    $posts=$combinedQuery->get()->jsonSerialize();



                }else{

                    $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.ad_id','ads_posts.created_time','ads_posts.message','ads_posts.image_url','ads_posts.type','ads_posts.status', 'pages.page_name', 'pages.page_image_url')
                    ->where('pages.page_id', '=', $page_id)
                    ->where('ads_posts.type', '=', $mediatype);



                    $posts1 = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.ad_id','posts_concurrents.created_time','posts_concurrents.message','posts_concurrents.image_url','posts_concurrents.type','posts_concurrents.status', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('pages.page_id', '=', $page_id)
                    ->where('posts_concurrents.type', '=', $mediatype);


                    $combinedQuery = $posts->union($posts1);
                    $posts=$combinedQuery->get()->jsonSerialize();


                }



        }else{


        $exists = page::where('page_id', $selectedpageid)->exists();

        if ($exists) {
            if ($end_date == "" && $mediatype == "") {
                $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.*', 'pages.page_name', 'pages.page_image_url')
                    ->where('pages.page_id', '=', $selectedpageid)
                    ->get()->jsonSerialize();
            } else if ($end_date != "" && $mediatype == "") {
                $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.*', 'pages.page_name', 'pages.page_image_url')
                    ->where('pages.page_id', '=', $selectedpageid)
                    ->whereBetween('created_time', [$start_date, $end_date])
                    ->get()->jsonSerialize();
            } else if ($end_date != "" && $mediatype != "") {
                $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.*', 'pages.page_name', 'pages.page_image_url')
                    ->whereBetween('created_time', [$start_date, $end_date])
                    ->where('pages.page_id', '=', $selectedpageid)
                    ->where('ads_posts.type', '=', $mediatype)
                    ->get()->jsonSerialize();
            } else {
                $posts = DB::table('ads_posts')
                    ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                    ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                    ->select('ads_posts.*', 'pages.page_name', 'pages.page_image_url')
                    ->where('pages.page_id', '=', $selectedpageid)
                    ->where('ads_posts.type', '=', $mediatype)
                    ->get()->jsonSerialize();
            }


        } else {


            if ($end_date == "" && $mediatype == "") {
                $posts = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.*', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('posts_concurrents.page_concurrent_id', '=', $selectedpageid)
                    ->get()->jsonSerialize();
            } else if ($end_date != "" && $mediatype == "") {
                $posts = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.*', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('posts_concurrents.page_concurrent_id', '=', $selectedpageid)
                    ->whereBetween('created_time', [$start_date, $end_date])
                    ->get()->jsonSerialize();
            } else if ($end_date != "" && $mediatype != "") {
                $posts = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.*', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('posts_concurrents.page_concurrent_id', '=', $selectedpageid)
                    ->whereBetween('created_time', [$start_date, $end_date])
                    ->where('posts_concurrents.type', '=', $mediatype)
                    ->get()->jsonSerialize();
            } else {
                $posts = DB::table('posts_concurrents')
                    ->join('pages_concurrents', 'pages_concurrents.page_concurrent_id', '=', 'posts_concurrents.page_concurrent_id')
                    ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
                    ->select('posts_concurrents.*', 'pages_concurrents.page_name', 'pages_concurrents.page_image_url')
                    ->where('posts_concurrents.page_concurrent_id', '=', $selectedpageid)
                    ->where('posts_concurrents.type', '=', $mediatype)
                    ->get()->jsonSerialize();
            }


        }


    }

        $postsNumber = count($posts);
        return [collect($posts)->skip(16 * ($currentPage - 1))->take(16)->toArray(), $postsNumber];


    }




    public function getCampaignPosts(Request $request)
    {
        $id = $request->input('campaign_id');
        $start_date = $request->input('start');
        $end_date = $request->input('end');
        $currentPage = $request->input('currentPage');

        // $campaign_id = DB::table('campaigns')
        // ->where('id', 3)
        // ->value('campaign_id');
        // dump($campaign_id);
        // $start_date='';
        // $end_date='';
        // $id=3;
        if ($end_date == "") {
            $posts = DB::table('ads_posts')
                ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                ->select('ads_posts.*', 'pages.page_name', 'pages.page_image_url')
                ->where('campaigns.id', '=', $id)
                ->get();
            $postsNumber = $posts->count();
        } else {
            $posts = DB::table('ads_posts')
                ->join('campaigns', 'ads_posts.campaign_id', '=', 'campaigns.campaign_id')
                ->join('pages', 'campaigns.page_id', '=', 'pages.page_id')
                ->select('ads_posts.*', 'pages.page_name', 'pages.page_image_url')
                ->whereBetween('created_time', [$start_date, $end_date])
                ->where('campaigns.id', '=', $id)
                ->get();
            // $posts=$posts->whereBetween('created_time', [$start_date, $end_date]);
            $postsNumber = $posts->count();
        }

        // $posts=$posts->jsonSerialize();
        return [collect($posts)->skip(16 * ($currentPage - 1))->take(16)->toArray(), $postsNumber];


    }




    public function get_pages()
    {
        $pages = page::select('page_name', 'page_image_url')->get();
        return $pages;

    }

    public function get_page_details(request $request){
        $page_name=$request->input('page_name');
        // $page_name='Innovation_page';
        $page=page::where('page_name',$page_name)->get()->jsonSerialize();  
        return $page;
    }

    public function get_card_insight(Request $request)
    {
        $ad_id = $request->input('post_id');

        // $adsPost = DB::table('ads_posts')->where('id', $post_id)->first();

        
        $insights = Insight::where('ad_id', $ad_id)
        ->orderBy('created_at', 'desc')
        ->limit(2)
        ->get();

        if ($insights->count() >= 2) {
            $latestInsight = $insights->first();
            $previousInsight = $insights->last();
        
            // Calculate the differences
            $reachDifference = $latestInsight->reach - $previousInsight->reach;
            $impressionDifference = $latestInsight->impression - $previousInsight->impression;
            $clicksDifference = $latestInsight->clicks - $previousInsight->clicks;
            $frequencyDifference = $latestInsight->frequency - $previousInsight->frequency;
        
            // Store the differences in an array
            $comparison = [
                'reach_difference' => $reachDifference,
                'impression_difference' => $impressionDifference,
                'clicks_difference' => $clicksDifference,
                'frequency_difference' => $frequencyDifference,
            ];
           
   
        } else {
            // Handle the case where there are insufficient insights
        }
        return [$latestInsight , $comparison];
    }



    public function getPgaesConcurrentByPgaeName(request $request)
    {
        $page_name = $request->input('page_name');

        $page = DB::table('pages')
            ->select('pages.page_name as label', 'pages.page_id as value')
            ->where('pages.page_name', '=', 'orange')
            ->get();
        $concurrent_page = DB::table('pages')
            ->select('pages_concurrents.page_name as label', 'pages_concurrents.page_concurrent_id as value')
            ->join('pages_concurrents', 'pages.page_id', '=', 'pages_concurrents.page_id')
            ->where('pages.page_name', '=', 'orange')
            ->get();


        $pages = $page->concat($concurrent_page);

        return $pages;
        // return [$page,$concurrent_page];


    }



    public function getReach(request $request){
        $ad_id = $request->input('post_id');
        $filter = $request->input('filter');
        
 
        // $ad_id = DB::table('ads_posts')
        //     ->select('ads_posts.ad_id')
        //     ->where('ads_posts.id', '=', $post_id)
        //     ->get();
        // $ad_id=$ad_id[0]->ad_id;

        if ($filter == 'day'){
            $reachs = DB::table('insights')
            ->select('insights.reach' ,'insights.created_at')
            ->where('insights.ad_id', '=', $ad_id)
            ->get();

            foreach($reachs as $reach){
                $value[] = floatval($reach->reach);
                $time[] = substr($reach->created_at,0,10);
            }
        }else{
            $reachs = insight::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('Max(reach) as reach')
            )
            ->where('insights.ad_id', '=', $ad_id)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

            foreach($reachs as $reach){
                $value[] = floatval($reach->reach);
                $time[] = $reach->year."-".$reach->month;
            }
        }
            
            return [$value,$time];






    } 



    public function getClicks(request $request){
        $ad_id = $request->input('post_id');
        $filter = $request->input('filter');
        

  
        // $ad_id = DB::table('ads_posts')
        //     ->select('ads_posts.ad_id')
        //     ->where('ads_posts.id', '=', $post_id)
        //     ->get();
        // $ad_id=$ad_id[0]->ad_id;

        if ($filter == 'day'){
            $clicks = DB::table('insights')
            ->select('insights.clicks' ,'insights.created_at')
            ->where('insights.ad_id', '=', $ad_id)
            ->get();
            
            foreach($clicks as $click){
                $value[] = floatval($click->clicks);
                $time[] = substr($click->created_at,0,10);
            }
        }else{
            $clicks = insight::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('Max(clicks) as clicks')
            )
            ->where('insights.ad_id', '=', $ad_id)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
  
            foreach($clicks as $click){
                $value[] = floatval($click->clicks);
                $time[] = $click->year."-".$click->month;
            }
        }

            return [$value,$time];


    } 



    public function test(Request $request)
    {
        //         $start_date=$request->input('start');
        //         $end_date=$request->input('end');
        //         $currentPage = $request->input('currentPage');
        //         $postsNumber = ads_post::count();
        //         $page_name= $request->input('page_name');
        //     if($end_date==""){
        //         $posts = posts_concurrent::select('posts_concurrents.id', 'posts_concurrents.post_id', 'posts_concurrents.created_time', 'posts_concurrents.message', 'posts_concurrents.image_url', 'posts_concurrents.page_concurrent_id', 'posts_concurrents.platform', 'pages_concurrents.page_concurrent_name', 'pages_concurrents.page_image_url')
        //         ->join('pages_concurrents', 'posts_concurrents.page_concurrent_id', '=', 'pages_concurrents.page_concurrent_id')
        //         ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
        //         ->where('pages.page_name', '=', str($page_name))
        //         ->orderBy('posts_concurrents.created_time', 'ASC')
        //         ->get();
        //     }else {
        //          $posts = posts_concurrent::select('posts_concurrents.id', 'posts_concurrents.post_id', 'posts_concurrents.created_time', 'posts_concurrents.message', 'posts_concurrents.image_url', 'posts_concurrents.page_concurrent_id', 'posts_concurrents.platform', 'pages_concurrents.page_concurrent_name', 'pages_concurrents.page_image_url')
        //             ->join('pages_concurrents', 'posts_concurrents.page_concurrent_id', '=', 'pages_concurrents.page_concurrent_id')
        //             ->join('pages', 'pages_concurrents.page_id', '=', 'pages.page_id')
        //             ->where('pages.page_name', '=', str($page_name))
        //             ->whereBetween('created_time', [$start_date, $end_date])
        //             ->orderBy('posts_concurrents.created_time', 'desc')
        //             ->get();
        //     }



        // $postsNumber = count($posts);
        // return [collect($posts)->skip(16*($currentPage-1))->take(16)->toArray(),$postsNumber];




    }

    public function testcrone()
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
                $link = 'https://graph.facebook.com/v15.0/' . $data['data'][0]['effective_object_story_id'] . '?fields=id,message,created_time,full_picture&access_token=EAADutQr9i3MBADcRUZCGU6MFq4xaMcZBsZBLT02nFEIoZCmoJcSmOfFzKNk77dlfoTf6z1RbdZCCbEUCQ1aVedIEiZB6Q12bA7aTCEwrGuhWZCTNBA6pqMdSjMZAv8YjdM3CBaGuuZBgZCtJY5GCpFo0mx2eQa1WILVrNW9XClJJdUKcOBYvlOgp1ZB';
                $adpost = Http::get($link)->json();
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
                        $record->image_url = $adpost['full_picture'];
                        $record->campaign_id = $campaign['campaign_id'];
                        $record->ad_id = $id['id'];
                        if($data['data'][0]['object_type']=='SHARE'){
                            $record->type='PHOTO';
                        }else{
                        $record->type=$data['data'][0]['object_type'];
                        }
                        dump($record);
                        $record->save();
                        // error_log('saved');
                    }else{
                        ads_post::where('ad_id',$adpost['id'])->update(['image_url'=> $adpost['full_picture']]);
                        
                    }
                }
             }
                // sleep(90);

            }    
        }
    }

    public function get_planed_posts(){
        $planes_posts=post_planifider::select('id as id','message as title','planification_time as start',)->get();
        return $planes_posts;
    }

}