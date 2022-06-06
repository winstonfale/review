<?php

namespace App\Http\Controllers;

use App\Models\ClickPostback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClickController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    public function index(Request $request) {
        return view('clicks');
    }

    public function indexData(Request $request)
    {
        $from = @$request->from ? Carbon::parse($request->from) : now();
        $to = @$request->to ? Carbon::parse($request->to) : now();


        $clicks = ClickPostback::select(
            DB::raw('DATE(created_at) as date'),

            DB::raw('SUM(CASE when pagesource = "home" then 1 ELSE 0 END) as home_clicks'),
            DB::raw('SUM(CASE when pagesource = "toplink" then 1 ELSE 0 END) as toplink_clicks'),
            DB::raw('SUM(CASE when pagesource = "casual" then 1 ELSE 0 END) as casual_clicks'),
            DB::raw('SUM(CASE when pagesource = "hookup" then 1 ELSE 0 END) as hookup_clicks'),
            DB::raw('SUM(CASE when pagesource = "mature" then 1 ELSE 0 END) as mature_clicks'),
            DB::raw('SUM(CASE when pagesource = "blog" then 1 ELSE 0 END) as blog_clicks'),
            DB::raw('SUM(CASE when pagesource = "comparison" then 1 ELSE 0 END) as comparison_clicks'),
            

            DB::raw('COUNT(id) as clicks'),
            DB::raw('SUM(CASE when postback IS NOT NULL then 1 ELSE 0 END) as conversions')
        )->whereBetween('created_at',[$from, $to])
        ->groupBy('date')
        ->get();

        return response($clicks);
    }


    public function store(Request $request) {

        $request->validate([
            'cid' => 'required'
        ]);

        $cp = ClickPostback::firstOrCreate([
            'cid' => $request->cid,
            'amount' => 0,

            'pagesource' => @$request->pagesource,
            'device' => @$request->device,
            'browser' => @$request->browser,
        ]);

        return response([
            'cid' => $cp->cid
        ]);
    }
}
