<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Doctrine\Common\Cache\Cache;
use Illuminate\Support\Facades\Cache;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Girl;
use Illuminate\Support\Str;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'name', 'email', 'password','token','is_conferd','active','money','isAdmin','email_token','phone','phone_conferd','actice_code','akcept','smsResetCode'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function girl(){
        return $this->hasOne('App\Girl');
    }

    //проверка есть ли анкета
    public function anketisExsis(){
        $rez=Cache::has('anket-is-exsist-'.$this->id); //получаем id анкеты
       // dump($rez);
        $user_id=Auth::user()->id;
      //  dump($user_id);
         $girl=Girl::select(['id','name','main_image','banned'])->where('user_id', $user_id)->first();
       // dump($girl);
        return $girl;

    }

    //создаем токен
    public function createMailConfermationToke() {
        $token=Str::random(16);
    //    echo $token;
    }

}
