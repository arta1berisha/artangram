<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

class JWTAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken();

            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {

            return $this->unauthorized('Your token has expired. Please, login again');
        } catch (TokenInvalidException $e) {

            return $this->unauthorized('Your token is invalid. Please, login again');
        } catch (JWTException $e) {

            return $this->unauthorized('Please, attach a Bearer Token to yor request');
        }

        if($user) {
            return $next($request);
        }

        return $this->unauthorized();
    }

    private function unauthorized($message = null)
    {
        return response()->json([
            'message' => $message ? $message : "You are unauthorized to access this resource",
            'success' => false
        ], 401);
    }
}
