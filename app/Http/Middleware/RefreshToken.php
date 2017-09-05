<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Carbon\Carbon;
use App\Jobs\InvalidateToken;

class RefreshToken
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

        $oldToken = JWTAuth::getToken();
        if (!$oldToken) {
            return $response;
        }
        $payload = JWTAuth::getPayload();
        $exp = $payload->get('exp');

        if ($diff = Carbon::now()->diffInSeconds(Carbon::createFromTimestamp($exp), false)) {
            if ($diff < 300) {
                if ($request->header('Token') === 'Refresh') {
                    JWTAuth::setBlacklistEnabled(false);
                    $newToken = JWTAuth::refresh();
                    JWTAuth::setBlacklistEnabled(true);
                    $response->headers->set('Authorization', 'Bearer '.$newToken);
                    $response->headers->set('Token', 'Refresh');

                    $job = (new InvalidateToken($oldToken))
                        ->onConnection('redis')
                        ->delay(Carbon::now()->addMinutes(1));
                    dispatch($job);

                    // logger('发任务', ['time'=>Carbon::now()]);
                } else {
                    $response->header('Token', 'Expiring');
                }
                
            }
        }

        return $response;
    }
}
