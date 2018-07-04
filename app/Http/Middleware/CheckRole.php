<?php

namespace App\Http\Middleware;

use Closure;

use Auth;
use Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $level)
    {
        // Log::info('level: ' . $level);
        $levelNum = intval($level);
        // Log::info('levelNum: ' . $levelNum);
        $userLevel = Auth::user()->roles->level;
        // Log::info('userLevel: ' . $userLevel);
        if($userLevel >= $levelNum) {
            return $next($request);
        }
        return redirect('/');
    }
}
