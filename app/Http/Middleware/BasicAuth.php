<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminUser = env('ADMIN_USER');
        $adminPass = env('ADMIN_PASS');
        
        $user = $request->getUser();
        $pass = $request->getPassword();
        
        if ($user !== $adminUser || $pass !== $adminPass) {
            return response('Unauthorized', 401, [
                'WWW-Authenticate' => 'Basic realm="Admin Area"'
            ]);
        }
        
        return $next($request);
    }
}
