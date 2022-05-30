<?php

namespace App\Http\Controllers;

use App\Models\ClickPostback;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function store(Request $request) {

        $postback = ClickPostback::where('cid',$request->s2)
            ->whereNull('postback')
            ->first();

        if(!$postback) {
            return response('Not Found',404);
        }
        $postback->postback = now();
        $postback->save();

       return response('Success');
    }
}
