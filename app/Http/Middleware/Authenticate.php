<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Arr;

class Authenticate extends Middleware
{

     protected $guards;


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
     public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }


    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            if (Arr::first($this->guards) === 'admin-web') {
                return route('management.login');
            }



            return route('login');
        }
    }
}
