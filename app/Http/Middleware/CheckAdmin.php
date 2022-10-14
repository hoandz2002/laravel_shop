<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
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
        // if (Auth::user()) {
        //     $user = Auth::user();
        //     if($user->status ==0){
        //         if($user->role == 1){
        //             return $next($request);
        //         }
        //         elseif($user->role == 0){
        //             return redirect()->route('client.index');
        //         }
        //     }else{
        //         dd('tai khoan khong hoat dong');
        //     }
        // }
        // return $next($request);
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->status == 0) {
                if ($user->role == 1) {
                    // return redirect()->route('users.list');
                    return $next($request);
                }if ($user->role == 0) {
                    return redirect()->route('client.index');
                    // dd('an cut');
                }
            } else{
                // session()->flash('error','Tài khoản củ bạn đã bị khóa');
                // return redirect()->route('auth.getLogin');
                // return back();
                return('tai khoan cua ban khong hoat dong');
            }
        }
    }
}
