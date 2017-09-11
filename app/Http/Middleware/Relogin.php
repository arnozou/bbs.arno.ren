<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class Relogin
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
        $response = $next($request);
        if (JWTAuth::getToken()) {
            return $response;
        }
        if ($reloginCookie = $request->cookie('relogin')) {
            logger('relogin', ['cookie' => $reloginCookie]);
            try {
                $user = JWTAuth::authenticate($reloginCookie);
                $newCookie = JWTAuth::refresh($reloginCookie);
            } catch (Exception $e) {
                return $response;
            }
            $newToken = JWTAuth::fromUser($user);
            $response->headers->set('Authorization', 'Bearer ' . $newCookie);
            $response->headers->set('Token', 'Refresh');
            $response->withCookie($newToken);
        }

        return $response;
    }
}
