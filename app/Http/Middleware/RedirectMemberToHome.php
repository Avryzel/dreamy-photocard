<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectMemberToHome
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->path() === 'member') {
            return redirect()->route('home');
        }

        return $next($request);
    }
}