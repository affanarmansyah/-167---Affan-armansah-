<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthLoggedin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = Auth::user()->id;
        $user = User::findOrFail($request->id);
        $users = $user->id;

        if ($auth != $users) {
            return response()->json([
                'message' => 'data not found'
            ]);
        }

        return $next($request);
    }
}
