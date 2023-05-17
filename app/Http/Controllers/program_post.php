<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\post_planifider;
use Carbon\Carbon;
class program_post extends Controller
{
    public function storeimg(request $request){

        if ($request->hasFile('file')) {
            $name=$request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('public/images'.$name);
        }
        $postMessage=$request->input('Postmessage');
        $planingTime=$request->input('planingTime');

        if (Storage::exists($path)) {
            // File exists in the specified path
            $imagePath = storage_path('app/' . $path);
            $pageId = '115449061452354';
            $apiEndpoint = "https://graph.facebook.com/$pageId/photos";
            $accessToken = 'EAASCGRuuJtQBAFSnOMG86nLlTJqcKtgnlcS9pXsIC0mLm5tIBV9PRhujmZBqglS0AON83GeEtAugfmwtZBPZA5U3c1pwuyHCrCRSADTBhexZAwiJEbbLs2FU1E5F7VZAzLrd8lZCtEsig0SCUZBK90uYDCHh08bZCUwLtRkXZBr9UXiM6RvTYWZAuaGwTfOe0imb0cFliOTRvZCrMgQujnpbI7YyGNJqoTNrW0ZD';
            
            $response = Http::attach(
                'source',
                fopen($imagePath, 'r'),
                $name
            )->post($apiEndpoint, [
                'published'=>false,
                "scheduled_publish_time"=>$planingTime,
                'message' => $postMessage,
                'access_token' => $accessToken,
            ]);

            if($response->successful()){

                $timestamp = Carbon::createFromTimestamp($planingTime)->toDateTimeString();
    
                $record=new post_planifider();
                $record->message=$postMessage;
                $record->image_path=$path;
                $record->page_id='115449061452354';
                $record->planification_time=$timestamp;
    
    
               
                $record->save();
            }

                return $response;
    }
}

public function publishnow(request $request){

    if ($request->hasFile('file')) {
        $name=$request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs('public/images'.$name);
    }
    $postMessage=$request->input('Postmessage');
    if (Storage::exists($path)) {
        // File exists in the specified path
        $imagePath = storage_path('app/' . $path);
        $pageId = '115449061452354';
        $apiEndpoint = "https://graph.facebook.com/$pageId/photos";
        $accessToken = 'EAASCGRuuJtQBAFSnOMG86nLlTJqcKtgnlcS9pXsIC0mLm5tIBV9PRhujmZBqglS0AON83GeEtAugfmwtZBPZA5U3c1pwuyHCrCRSADTBhexZAwiJEbbLs2FU1E5F7VZAzLrd8lZCtEsig0SCUZBK90uYDCHh08bZCUwLtRkXZBr9UXiM6RvTYWZAuaGwTfOe0imb0cFliOTRvZCrMgQujnpbI7YyGNJqoTNrW0ZD';
        
        $response = Http::attach(
            'source',
            fopen($imagePath, 'r'),
            $name
        )->post($apiEndpoint, [
            'message' => $postMessage,
            'access_token' => $accessToken,
        ]);
        // $timestamp = Carbon::createFromTimestamp($planinTime)->toDateTimeString();
        $publishtime=Carbon::now()->format('Y-m-d H:i:s');
        $record=new post_planifider();
        $record->message=$postMessage;
        $record->image_path=$path;
        $record->page_id='115449061452354';
        $record->planification_time=$publishtime;


       
        $record->save();

            return $response;
}
}
}
