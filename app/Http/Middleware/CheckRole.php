<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        // dd($user->roles, $roles);

        $userRoles = array_values($user->roles);
        if ((!empty($roles) && isset($roles[0])) && (!$user || ! in_array($roles[0], $userRoles))) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
