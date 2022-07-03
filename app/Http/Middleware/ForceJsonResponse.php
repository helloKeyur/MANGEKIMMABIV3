<?php

namespace App\Http\Middleware;

use Closure;
use Response;
use App\Models\OauthClient;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */


           public function handle($request, Closure $next)
        {
           
           $request->headers->set('Accept', 'application/json');
           $headers = apache_request_headers();

           if(!isset($headers['Key'])){
                            return response()->json([
                                        'success' => false,
                                        'message' => $headers,
                                    ], 401);
           }
          
           $exists = OauthClient::where("secret",$headers['Key'])->exists();

           if(!$exists){
                   return response()->json([
                        'success' => false,
                        'message' => \App\Models\User::encrypter('Client Not Found'),
                    ], 401);
            }


           // return Response::json(); 
          
            return $next($request);
        }


}
