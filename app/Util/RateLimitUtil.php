<?php

namespace App\Util;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class RateLimitUtil
{
    public static function rateLimit(int $authenticatedLimit, int $unauthenticatedLimit)
    {
        return function (Request $request) use ($authenticatedLimit, $unauthenticatedLimit) {
            return $request->user()
                ? Limit::perMinute($authenticatedLimit)
                    ->by($request->user()->id)
                    ->response(function () {
                        return response()->json([
                            'message' => 'Você atingiu o limite de requisições. Aguarde e tente novamente.',
                        ], 429);
                    })
                : Limit::perMinute($unauthenticatedLimit)
                    ->by($request->ip())
                    ->response(function () {
                        return response()->json([
                            'message' => 'Muitas requisições vindas do seu IP. Tente novamente mais tarde.',
                        ], 429);
                    });
        };
    }
}
