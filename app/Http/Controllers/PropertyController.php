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
                    'reviews' => 3694,
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
                ],

                'hookup69' => [
                    'url' => 'https://hookup69.com/',
                    'members' => 224456,
                    'reviews' => 2645,
                    'ratings' => 4.8
                ],

                'wannahookup' => [
                    'url' => 'https://wannahookup.com/',
                    'members' => 171023,
                    'reviews' => 2047,
                    'ratings' => 4.8
                ],

                'honeynearby' => [
                    'url' => null,
                    'members' => null,
                    'reviews' => 1874,
                    'ratings' => 3.9
                ],

                'Shag2night' => [
                    'url' => null,
                    'members' => null,
                    'reviews' => 1874,
                    'ratings' => 4.1
                ],
            ]
        ]);
    }
}
