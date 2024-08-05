<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{


    protected $modelName;


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {

        if (app($role)::where('username', Auth::user()->username)->exists()) {
            // Username exists, proceed with the request
            return $next($request);
        }
        return response()->json(['error' => 'forbidden.'], 404);
}}
