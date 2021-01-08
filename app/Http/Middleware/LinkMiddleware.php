<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $segmentOne = $request->segment(1);
        $segmentTwo = $request->segment(2);

        if($user->user_type == 'user'){
            if($segmentOne == 'department' || $segmentOne == 'user'){
                return redirect('/');
            }

            if($segmentOne == 'meeting' && $segmentTwo == 'admin'){
                return redirect('/');
            }
        }

        return $next($request);
    }
}
