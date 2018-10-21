<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
use App\Girl;
//use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
class CheckAnketExist
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
        if(Auth::check()){
            $user=Auth::user();
            $user_id=$user->getAuthIdentifier();
            $girl=Girl::select(['id','name','login','email','phone','main_image','description'])->where('user_id', $user_id)->first();

            dump($girl);
            if ($girl!=null) {
                Cache::put('anket-is-exsist-' . $user_id, true, $girl->id);
               // Cache::put('anket-is-exsist2' . $user_id, true, $girl->main_image);
            }
            {
                Cache::put('anket-is-exsist-' . 'null', false);
            }


        }
        return $next($request);
    }
}
