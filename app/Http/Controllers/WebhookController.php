<?php

namespace App\Http\Controllers;

use App\Models\ClickPostback;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function store(Request $request) {

        $postback = ClickPostback::where('cid',$request->s1)
            ->whereNull('postback')
            ->first();

        if(!$postback) {
            info('Postback:' . json_encode($request->all()));
            return response('Not Found',404);
        }
        $postback->amount = $request->s2;
        $postback->postback = now();
        $postback->save();

       return response('Success');
    }

    public function conversion(Request $request) 
    {
        $postback = ClickPostback::where('cid',$request->cid)
            ->whereNull('postback')
            ->first();

        if(!$postback) {
            info('Postback:' . json_encode($request->all()));
            return response('Not Found',404);
        }
        $postback->amount = @$request->amount ? $request->amount : 0;
        $postback->postback = now();
        $postback->save();

       return response('Success');
    }
}
