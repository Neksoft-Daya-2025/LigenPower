<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Allow this app (merchant.ligenpower.com) to be embedded in iframes
 * from the main site (ligenpower.com) and localhost for dashboard integration.
 */
class AllowEmbedFromMainSite
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->remove('X-Frame-Options');
        $response->headers->set(
            'Content-Security-Policy',
            "frame-ancestors 'self' https://ligenpower.com https://www.ligenpower.com https://*.ligenpower.com http://localhost:8000 http://localhost http://127.0.0.1:8000 http://127.0.0.1"
        );

        return $response;
    }
}
