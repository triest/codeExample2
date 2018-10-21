<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\Message;
use Auth;

class Girl extends Model
{
    //
    protected $fillable = [
        'name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','publicated',
        'money','beginvip','endvip','sex','meet','weight','height','country_id','region_id','city_id','banned','created_at'
    ];


    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function getVip(){
        $current_date=Carbon::now();
        $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
            ->where('beginvip','<',$current_date)
            ->where('endvip','>',$current_date)
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC');
        return $vipGirls;
    }

    //получаем сообщения
    public function getMessages(){
        if (Auth::check()) {
            $user = Auth::user();  // и если админ
            $user_id=$user->id;
        }
        else{
            return null;
        }
        //  dump($user_id);
        $girl=Girl::select(['id','name','main_image','banned'])->where('user_id', $user_id)->first();

        if ($user->isAdmin==0) {
            if ($girl != null) {
                $messages = Message::select('id', 'text', 'girl_id', 'fromAdmin', 'date', 'readed')
                    ->where('girl_id', $girl->id)
                    ->where('fromAdmin', '=', 1)
                    ->where('readed', '=', 0)
                    ->get();
               // dump($messages);
                if (empty($messages)) {
                    return null;
                }
                return $messages;
            }
        }
        else {
            if ($girl != null) {
                $messages = Message::select('id', 'text', 'girl_id', 'fromAdmin', 'date', 'readed')
                    ->where('girl_id', $girl->id)
                    ->where('fromAdmin','=' , 0)
                    ->where('readed', '=', 0)
                    ->get();
             //  dump($messages);

                return $messages;
            }
            return null;
        }
    }
}
