<?php

namespace App\Http\Controllers;

use App\Models\ClickPostback;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function store(Request $request) {

        $request->validate([
            'cid' => 'required'
        ]);

        ClickPostback::firstOrCreate([
            'cid' => $request->cid,
            'amount' => 0
        ]);

        return response()->noContent();
    }
}
