<?php

namespace App\Http\Controllers;

use App\Models\ClickPostback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Since;

class ClickController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('store');
    }

    public function index(Request $request)
    {
        return view('clicks');
    }

    

    public function overall()
    {

        $data = [
            'today' => ClickPostback::select('amount')->whereBetween('postback', [today(), now()])->sum('amount'),
            //    'yesterday' => ClickPostback::select('amount')->whereBetween('postback',[today()->subDay()->startOfDay(),today()->subDay()->endOfDay()])->sum('amount'),
            'this_week' => ClickPostback::select('amount')->whereBetween('postback', [today()->startOfWeek(), now()])->sum('amount'),
            'this_month' => ClickPostback::select('amount')->whereBetween('postback', [today()->startOfMonth(), now()])->sum('amount'),
            'this_year' => ClickPostback::select('amount')->whereBetween('postback', [today()->startOfYear(), now()])->sum('amount'),
        ];

        return response($data);
    }

    public function indexData(Request $request)
    {
        $from = @$request->from ? Carbon::parse($request->from)->startOfDay() : today()->subDay(7);
        $to = @$request->to ? Carbon::parse($request->to)->endOfDay() : now();


        $clicks = ClickPostback::select(
            DB::raw('DATE(created_at) as date'),

            DB::raw('COUNT(CASE when postback IS NOT NULL and site_id = 1 then id END) as shag_conversions'),
            DB::raw('COUNT(CASE when site_id = 1 then id END) as shag_clicks'),
            DB::raw('SUM(CASE when postback IS NOT NULL and site_id = 1 then amount ELSE 0 END) as shag_earnings'),

            DB::raw('COUNT(CASE when postback IS NOT NULL and site_id = 2 then id END) as hut_conversions'),
            DB::raw('COUNT(CASE when site_id = 2 then id END) as hut_clicks'),
            DB::raw('SUM(CASE when postback IS NOT NULL and site_id = 2 then amount ELSE 0 END) as hut_earnings'),

            DB::raw('COUNT(CASE when postback IS NOT NULL and site_id = 3 then id END) as site_2_night_conversions'),
            DB::raw('COUNT(CASE when site_id = 3 then id END) as site_2_night'),
            DB::raw('SUM(CASE when postback IS NOT NULL and site_id = 3 then amount ELSE 0 END) as site_2_night_earnings'),

            DB::raw('COUNT(CASE when postback IS NOT NULL and site_id = 4 then id END) as honey_nearby_conversions'),
            DB::raw('COUNT(CASE when site_id = 4 then id END) as honey_nearby'),
            DB::raw('SUM(CASE when postback IS NOT NULL and site_id = 4 then amount ELSE 0 END) as honey_nearby_earnings'),

            DB::raw('COUNT(id) as clicks'),
            DB::raw('SUM(CASE when postback IS NOT NULL then 1 ELSE 0 END) as conversions'),
            DB::raw('SUM(CASE when postback IS NOT NULL then amount ELSE 0 END) as earnings')

        )->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();

        return response($clicks);
    }


    public function store(Request $request)
    {

        $request->validate([
            'cid' => 'required'
        ]);

        $cp = ClickPostback::firstOrCreate([
            'cid' => $request->cid,
            'amount' => 0,

            'page_source' => @$request->page_source,
            'device' => @$request->device,
            'browser' => @$request->browser,

            's1' => @$request->s1,
            's2' => @$request->s2,
            's3' => @$request->s3,
            's4' => @$request->s4,
            's5' => @$request->s5,

            'currency' => $this->getCurrency($request->site_id),
            'site_id' => @$request->site_id,
            'site_source' => @$request->site_source,
        ]);

        return response([
            'cid' => $cp->cid
        ]);
    }

    //  const Shagtoday =   1;
    // const HookUpToday =   2;
    // const Site2night = 3;
    // const HoneyNearby = 4;
    // const HookUp69 = 5;
    // const WannaHookup = 6;

    private function getCurrency($site_id)
    {

        $eur = [1, 2, 3, 4];
        $cad = [5];
        $usd = [1, 2, 3, 4];

        if (in_array($site_id, $eur)) {
            return 'EUR';
        }

        if (in_array($site_id, $cad)) {
            return 'CAD';
        }

        return 'USD';
    }
}
