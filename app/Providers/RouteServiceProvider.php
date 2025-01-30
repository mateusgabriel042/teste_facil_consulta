<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use App\Util\RateLimitUtil;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('auth', RateLimitUtil::rateLimit(5, 5));
        RateLimiter::for('user', RateLimitUtil::rateLimit(60, 20));
        RateLimiter::for('city', RateLimitUtil::rateLimit(60, 20));
        RateLimiter::for('doctor', RateLimitUtil::rateLimit(60, 20));
        RateLimiter::for('patient', RateLimitUtil::rateLimit(60, 20));
        RateLimiter::for('consultation', RateLimitUtil::rateLimit(60, 20));

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(function () {
                    require base_path('routes/api.php');
                });

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
