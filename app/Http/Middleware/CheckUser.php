<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
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
        if($request->session()->has("user")){
            if(session("user")->role_id == 2){
                return redirect()->to("/");
            }
            return $next($request);
        }else{
            return redirect()->to("/");
        }
    }
}
