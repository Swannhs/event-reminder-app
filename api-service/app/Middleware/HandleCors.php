<?php

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleCors
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $response->headers->set("Access-Control-Allow-Origin", "*");
            $response->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", "Content-Type, Authorization, X-Requested-With");
            $response->headers->set("Access-Control-Allow-Credentials", "true");
        }

        return $response;
    }
}
