<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
class HandleBlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()){
            if($request->user()->blocked_reason != null){
                $request->user()->currentAccessToken()->delete();
                return response()->json([
                    'status'=> 'blocked',
                    'message'=> 'User blocked',
                    'reason' => User::$BLOCKED_REASONS [$request->user()->blocked_reason] ,
                ]);
            }
        }
        return $next($request);

    }
}
