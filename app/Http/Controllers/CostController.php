<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $costs = Cost::latest()->paginate(20);
        return response($costs);
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
