<?php

namespace App\Http\Controllers;

use App\Models\ClickPostback;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function store(Request $request) {

        $request->validate([
            'cid' => 'required|digits:16'
        ]);

        ClickPostback::firstOrCreate([
            'cid' => $request->cid
        ]);

        return response()->noContent();
    }
}
