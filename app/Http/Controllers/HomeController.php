<?php

namespace App\Http\Controllers;

use App\Enums\WebsiteIds;
use App\Models\ClickPostback;
use App\Models\Cost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function comments()
    {
        return view('reviews');
    }

    public function websites()
    {
        return view('websites');
    }

    public function dashboard(Request $request)
    {
        $siteId = $request->siteId;

        $from = Carbon::parse($request->from)->startOfDay();
        $to= Carbon::parse($request->to)->startOfDay();

        $campaigns = ClickPostback::query()
            ->select(
                DB::raw('COUNT(id) as clicks'),
                DB::raw('SUM(CASE when postback IS NOT NULL then 1 ELSE 0 END) as conversions'),
                DB::raw('SUM(CASE when postback IS NOT NULL then amount ELSE 0 END) as amount'),
                'site_id'
            )
            ->whereBetween(
                'created_at', [$from, $to]
            )
            ->groupBy('site_id')
            ->get();

        $campaigns = $campaigns->map(function($campaign) {
            $campaign->name = $campaign->name ?? 'organic';
            return $campaign;
        });

        $costs = Cost::select('cost', 'from', 'to','id')
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->get();
        
        return response([
            'campaigns' => $campaigns,
            'clicks' => $campaigns->sum('clicks'),
            'conversion' => $campaigns->sum('conversions'),
            'earnings' => $campaigns->sum('amount'),
            'cost' => $costs->sum('cost')
        ]);
    }

    public function websitesInfo()
    {
        $sites = collect(WebsiteIds::getKeys());

        $sites = $sites->map(function($site) {

            $site = [
                'name' => $site,
                'id' => WebsiteIds::getValue($site),
                'access_key' => $i = encrypt(WebsiteIds::getValue($site)),
            ];
            return $site;
        });

        return response($sites,200);
    }
}
