<?php

namespace App\Http\Controllers;

use App\Enums\WebsiteIds;
use Illuminate\Http\Request;

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

    public function websites()
    {
        return view('websites');
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
