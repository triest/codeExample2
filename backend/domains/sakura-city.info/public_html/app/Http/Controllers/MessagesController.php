<?php

namespace App\Http\Controllers;

//use Illuminate\Validation\Validator;
use App\Photo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Comment;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Filesystem\Exception\IOException;
use function Symfony\Component\VarDumper\Tests\Caster\reflectionParameterFixture;
//use Zend\InputFilter\Input;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Contracts\Auth\Guard;

use App\Repositories\ImageRepository;
use Carbon\Carbon;
use File;
use Storage;
use DateTime;
use App\User;
use App\Girl;
use App\Services;
use App\DemoMail;
use App\Message;
use Mail;
use settype;
use App\Mail\Reminder;


class MessagesController extends Controller
{
    function getMessagesPage(){
        echo 'test';
        if (Auth::guest()){
            return redirect('/login');
        }
        $user=Auth::user();
        if($user==null){
            return redirect('/login');
        }

        dump($user);


        //die();
        $messages_sended=Message::select(['text','sender_id','resiver_id','date','status'])
            ->where('sender_id',$user->id)
           // ->orWhere('resiver_id',$user->id)
            ->get();

        dump($messages_sended);
     //   die();
        $messages_resived=Message::select(['text','sender_id','resiver_id','date','status'])
          //  ->where('sender_id',$user->id)
            ->where('resiver_id',$user->id)
            ->get();

        dump($messages_resived);
        die();
        $outheher_user=$messages_sended->resiver_id;
        dump($outheher_user);
      //  die();
        $messages=Message::select(['text','sender_id','resiver_id','date','status'])
            ->Where('sender_id',$user->id)
            ->orWhere('resiver_id',$user->id)
            ->get();
        dump($messages);
        die();
/*
        $outher_user=User::select(['name'])
            ->where('id',$resiver_id)
            ->get();*/

    //   dump($messages);


       return view('messages.dialog')->with(['messages_sended'=>$messages_sended,'messages_resived'=>$messages_resived,'this_user'=>$user,'outher_user'=>$outheher_user]);

    }

}