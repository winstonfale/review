<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PropertyController extends Controller
{
    public function index() {
        return response([
            'sites' => [
                'shagtoday' => [
                    'url' => 'https://shagtoday.co.uk/',
                    'members' => 418490,
                    'reviews' => 5320,
                    'ratings' => 4.9
                ],
                'hookuptoday' => [
                    'url' => 'https://hookuptoday.co.uk/',
                    'members' => 321040,
                    'reviews' => 3280,
                    'ratings' => 4.8
                ],
                'beedate' => [
                    'url' => null,
                    'members' => null,
                    'reviews' => 2884,
                    'ratings' => 4.1
                ],
                'ohcupid' => [
                    'url' => null,
                    'members' => null,
                    'reviews' => 1874,
                    'ratings' => 3.9
                ]
            ]
        ]);
    }
}
