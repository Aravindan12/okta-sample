<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Okta\JwtVerifier\Adaptors\FirebasePhpJwt;
use Okta\JwtVerifier\JwtVerifierBuilder;

class VerifyJwt
{
    public function handle(Request $request, Closure $next)
    {
        // Instantiate the Okta JWT verifier
        $jwtVerifier = (new JwtVerifierBuilder())
            ->setAdaptor(new FirebasePhpJwt())
            ->setAudience('api://default')
            ->setClientId('0oa6hvtje6MkQzZbG5d7')
            ->setIssuer('https://dev-62008175.okta.com/oauth2/default')
            ->build();
        try {
            // dd($request->bearerToken());
            // Verify the JWT passed as a bearer token
            $jwtVerifier->verify($request->bearerToken());
            dd($jwtVerifier);
            return $next($request);
        } catch (\Exception $exception) {
            dd('v');
            // Log exceptions
            return $exception;
        }

        // If we couldn’t verify, assume the user is unauthorized
        // return response('Unauthorized', 401);
    }

}
