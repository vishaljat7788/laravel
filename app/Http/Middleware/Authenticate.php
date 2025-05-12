<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */


     protected function redirectTo($request)
    {
        return $request->expectsJson() ? null : route('login');

        // if (!$request->expectsJson()) {
        //     if ($request->is('customer/')) {
        //         return route('customer.index');
        //     } else {
        //         return route('login');
        //     }
        // }
    }


  
       




    // protected function redirectTo(Request $request): ?string
    // {
    //     return $request->expectsJson() ? null : route('admin.login');
    // }
}

