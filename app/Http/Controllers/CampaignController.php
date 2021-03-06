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

        return [
            "campaigns"=>[
              [
                "clicks"=>1650,
                "conversions"=>"37",
                "amount"=>38.00000000000004,
                "site_id"=>0,
                "name"=>"organic"
              ],
              [
                "clicks"=>954,
                "conversions"=>"51",
                "amount"=>50.1,
                "site_id"=>1,
                "name"=>"organic"
              ],
              [
                "clicks"=>277,
                "conversions"=>"5",
                "amount"=>26.25,
                "site_id"=>3,
                "name"=>"organic"
              ],
              [
                "clicks"=>449,
                "conversions"=>"16",
                "amount"=>16,
                "site_id"=>2,
                "name"=>"organic"
              ],
              [
                "clicks"=>147,
                "conversions"=>"5",
                "amount"=>25,
                "site_id"=>4,
                "name"=>"organic"
              ],
              [
                "clicks"=>10,
                "conversions"=>"0",
                "amount"=>0,
                "site_id"=>7,
                "name"=>"organic"
              ],
              [
                "clicks"=>13,
                "conversions"=>"1",
                "amount"=>1.7,
                "site_id"=>8,
                "name"=>"organic"
              ]
            ],
            "clicks"=>3500,
            "conversion"=>115,
            "earnings"=>157.05000000000004,
            "cost"=>0
        ];


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
