<?php

namespace App\Http\Controllers;

use App\Models\ClickPostback;
use App\Models\Cost;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('costs');
    }

    public function data(Request $request)
    {
        $from = @$request->from ? Carbon::parse($request->from)->startOfDay() : today()->subDay(7);
        $to = @$request->to ? Carbon::parse($request->to)->endOfDay() : now();

        $earnings = ClickPostback::select(
            'site_id',
            DB::raw('SUM(CASE when postback IS NOT NULL then amount ELSE 0 END) as earnings')
        )->whereBetween('created_at', [$from, $to])
            ->groupBy('site_id')
            ->get();


        $costs = Cost::select('cost', 'from', 'to')
            ->whereBetween('created_at', [$from, $to])
            ->latest()
            ->get();


        return response([
            'costs' => [
                'list' => $costs,
                'total' => $costs->sum('cost')
            ],
            'earnings' => [
                'list' => $earnings,
                'total' => $earnings->sum('earnings')
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cost' => 'required|numeric'
        ]);

        Cost::create([
            'cost' => $request->cost,
            'from' => Carbon::parse($request->from),
            'to' => Carbon::parse($request->to)
        ]);

        return response('success');
    }

    public function delete($id)
    {
        $cost = Cost::findOrFail($id);
        $cost->delete();

        return response('Delete success');
    }
}
