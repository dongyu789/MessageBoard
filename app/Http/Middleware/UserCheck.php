<?php

namespace App\Http\Middleware;

use Closure;

class UserCheck
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
        //检测用户名是否为纯数字
        $user = $request->get('username');

        $strlen = strlen($user);

        for($i = 0; $i < $strlen; $i++) {
            if($user[$i] < '0' || $user[$i] > '9') {
                return redirect()->back();
            }
        }
        return $next($request);
    }
}
