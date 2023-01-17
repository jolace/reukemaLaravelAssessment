<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if($request->has(env('API_KEY_NAME')))
        {
            $apiKeyValue    =   $request->get(env('API_KEY_NAME'));
            $configApiKeyValue  = env('API_KEY_VALUE');
            
            if($apiKeyValue == $configApiKeyValue)
            {
                return $next($request);
            }
        }
        
        return response(['error'=>'Wrong api key'],401);
    }
}
