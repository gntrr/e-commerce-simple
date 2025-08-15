<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $username = $request->getUser();
        $password = $request->getPassword();
        
        if (!$username || !$password) {
            return $this->unauthorizedResponse();
        }
        
        // Cari user berdasarkan email dan pastikan role adalah admin
        $user = User::where('email', $username)
                   ->where('role', 'admin')
                   ->first();
        
        if (!$user || !Hash::check($password, $user->password)) {
            return $this->unauthorizedResponse();
        }
        
        // Set user yang sudah terautentikasi ke request
        $request->setUserResolver(function () use ($user) {
            return $user;
        });
        
        return $next($request);
    }
    
    /**
     * Return unauthorized response
     */
    private function unauthorizedResponse(): Response
    {
        return response('Unauthorized. Please login with admin credentials.', 401, [
            'WWW-Authenticate' => 'Basic realm="Admin Area"'
        ]);
    }
}
