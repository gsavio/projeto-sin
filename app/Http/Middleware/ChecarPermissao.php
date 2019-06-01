<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ChecarPermissao
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
        // Acesso somente acima de Rank 2 (Admin)
        if(Auth::user()->rank < 2) {
            return redirect(route('home'))->with('status', 'Você não possui permissão para acessar esta função.');;
        }

        return $next($request);
    }
}
