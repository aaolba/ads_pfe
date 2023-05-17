<?php
use App\Models\ads_post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/allPosts','getDataController@getfilteredPostes');


Route::get('/allCampaigns','getDataController@getAllcampaigns');


Route::get('/post_campaign','getDataController@getCampaignPosts');


Route::get('/pages','getDataController@get_pages');


Route::get('/card_insights','getDataController@get_card_insight');


Route::get('/adminPages_and_concurrents','getDataController@getPgaesConcurrentByPgaeName');


Route::get('/getpageDetails','getDataController@get_page_details');


Route::get('/reachstat','getDataController@getReach');


Route::get('/clickstat','getDataController@getClicks');


Route::get('/gptGenerate','gptController@generateContent');


Route::post('/storePhoto','program_post@storeimg');


Route::post('/publichnow','program_post@publishnow');


Route::get('/get_planed_posts','getDataController@get_planed_posts');
