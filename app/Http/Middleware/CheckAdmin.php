<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
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
                return $next($request);
            }
            return redirect()->to("/");
        }else{
            return redirect()->to("/");
        }
    }
}
