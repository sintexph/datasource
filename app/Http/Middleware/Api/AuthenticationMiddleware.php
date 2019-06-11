<?php

namespace App\Http\Middleware\Api;

use Closure;
use App\AccessToken;

class AuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        # Get the bearer name
        $token_name=$request->header('bearer-name');
        $access=AccessToken::where('name','=',$token_name)->First();
        
        if($access==null)
            return response()->json(['response'=>'error','message'=>'You have no rights to access the service.'],403);
        else
        {
            if(strcmp($access->token,$token)!=0)
            {
                return response()->json(['response'=>'error','message'=>'You have no rights to access the service.'],403);
            }
        }

        return $next($request);

    }
}
