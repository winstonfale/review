<?php

namespace App\Http\Controllers;

use App\Enums\WebsiteIds;
use App\Models\ClickPostback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('campaigns');
    }

    public function data(Request $request)
    {
        $groupBy = $request->groupBy;
        $siteId = $request->siteId;

        $s1 = @$request->s1;
        $s2 = @$request->s2;
        $s3 = @$request->s3;
        $s4 = @$request->s4;
        $s5 = @$request->s5;

        $from = Carbon::parse($request->from)->startOfDay();
        $to= Carbon::parse($request->to)->endOfDay();

        $campaigns = ClickPostback::query()
            ->select(
                DB::raw('COUNT(id) as clicks'),
                DB::raw('SUM(CASE when postback IS NOT NULL then 1 ELSE 0 END) as conversions'),
                $groupBy . ' as name',
            )
            ->when($siteId, function ($q)  use ($siteId) {
                return $q->where('site_id', $siteId);
            })
            ->when($s1, function ($q)  use ($s1) {
                return $q->where('s1', $s1);
            })
            ->when($s2, function ($q)  use ($s2) {
                return $q->where('s2', $s2);
            })
            ->when($s3, function ($q)  use ($s3) {
                return $q->where('s3', $s3);
            })
            ->when($s4, function ($q)  use ($s4) {
                return $q->where('s4', $s4);
            })
            ->when($s5, function ($q)  use ($s5) {
                return $q->where('s5', $s5);
            })
            ->whereBetween(
                'created_at', [$from, $to]
            )
            ->groupBy($groupBy)
            ->get();


        $campaigns->map(function($campaign) use ($groupBy) {
            $campaign->name = $campaign->name ?? 'organic';
            $campaign->tag = $groupBy;
            return $campaign;
        });
        
        return response($campaigns);
    }
}
