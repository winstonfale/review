<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;

use Closure;

class IpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (App::environment('production') && !(in_array($request->ip(), config('whitelist.ip')))) {
            return response(['message' =>  'Bad Request - Invalid IP', 'ip' => $request->ip()], 400);
        }

        return $next($request);
    }
}
