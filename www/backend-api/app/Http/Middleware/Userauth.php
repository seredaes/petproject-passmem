<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Response\GlobalResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Userauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        $globalResponse = new GlobalResponse();
        $response = $globalResponse->error()->setMessage("Пользователь не авторизирован")->get();

        if($token === null) {
            return \response()->json($response, 401);
        }

        $user = User::whereAccessToken($token)->first();
        if($user === null) {
            return \response()->json($response, 401);
        }

        return $next($request);
    }
}
