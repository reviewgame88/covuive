<?php

namespace App\Http\Middleware;
use App\User;
use Closure;
use Auth;
class LogInAdmin
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
        if(Auth::check())
        {
            if (Auth::user()->level == 1) {
              return $next($request);
            }
        }
          return redirect('/');
    }
}
