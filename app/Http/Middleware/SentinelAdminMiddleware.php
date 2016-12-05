<?php

namespace App\Http\Middleware;

use Closure;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class SentinelAdminMiddleware
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
        if(!Sentinel::check())
        {
            return redirect("/")->with('message','Necesitas estar logueado para acceder');
        }
        else if(!Sentinel::inRole('admins'))
        {
            $user = Sentinel::getUser();
            return redirect("cliente/".$user->client->slug)->with('message','Acceso denegado');
        }
        return $next($request);
    }
}
