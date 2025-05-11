<?php

namespace App\Http\Middleware;

use App\Trait\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        if (Auth::user()->user_type === 'admin') {
            return $next($request);
        }else if(Auth::user()->user_type === 'user'){
            return redirect()->route('dashboard');
        }

    }
}
