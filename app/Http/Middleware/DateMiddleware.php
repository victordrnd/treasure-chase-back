<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class DateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $date)
    {
        $date = Carbon::parse($date);
        if($date > Carbon::now()){
            return response()->json(['errors' => ["Le service sera accessible ".$date->diffForHumans()]], 401);
        }
        return $next($request);
    }
}
