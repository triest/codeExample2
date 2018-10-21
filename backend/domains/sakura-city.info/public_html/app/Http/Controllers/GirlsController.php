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
use App\Message;
use phpDocumentor\Reflection\Types\Null_;
use Response;
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
use App\Region;
use App\City;
use App\Country;
use Mail;
use settype;
use App\Mail\Reminder;
//use Uts\HotelBundle\Entity\Country;


class GirlsController extends Controller
{
    function index(){
        $girls=Girl::select(['id','name','login','email','phone','main_image','description'])
            ->orderBy('created_at','DESC')->simplePaginate(9);
      //  dump($girls);
        $current_date=Carbon::now();
     //   dump($current_date); #алогин ли
      if (Auth::check()) {
          $user = Auth::user();  // и если админ
          if ($user->isAdmin == 1) {
              //  echo 'admin';
              $girls=Girl::select(['id','name','login','email','phone','main_image','description','banned'])
                  ->orderBy('created_at','DESC')->simplePaginate(9);
          }
          else{
              $girls=Girl::select(['id','name','login','email','phone','main_image','description','sex'])
                  ->where('banned','=','0')
                  ->orderBy('created_at','DESC')
                 // ->orderBy(,'ASC')
                  ->Paginate(9);
          }
      }else{
          $girls=Girl::select(['id','name','login','email','phone','main_image','description','sex'])
              ->where('banned','=','0')
              ->orderBy('created_at','DESC')
            //  ->orderBy('rating','ASC')
              ->Paginate(9);
      }




     /*   $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
            ->where('beginvip','<',$current_date)
            ->where('endvip','>',$current_date)
            ->orderBy('created_at','DESC')
         //   ->orderBy('rating','ASC')
            ->Paginate(9);*/
       // dump($vipGirls);
        return view('index')->with(['girls'=>$girls,/*'vipGirls'=>$vipGirls*/]);
    }

    function index2(){
        $girls=Girl::select(['id','name','login','email','phone','main_image','description'])->simplePaginate(9);
        //  dump($girls);
        $current_date=Carbon::now();
        //   dump($current_date);

        $girls=Girl::select(['id','name','login','email','phone','main_image','description','sex'])
            //  ->where('vip','=','1')
            ->orderBy('created_at','DESC')
        //    ->orderBy('rating','ASC')
            ->Paginate(9);
        //    dump($girls);
        //  dump($girls);

        $countries=collect(DB::select('select * from countries')); //получаем страны

        //получаем регионы
        $regions=collect(DB::select('select * from regions where id_country=1')); //получаем страны

        $cities=collect(DB::select('select * from cities where id_region=1'));


        $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
            ->where('beginvip','<',$current_date)
            ->where('endvip','>',$current_date)
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC')
            ->Paginate(9);
        // dump($vipGirls);


        return view('index2')->with(['girls'=>$girls,'vipGirls'=>$vipGirls,'countries'=>$countries,'regions'=>$regions,'cities'=>$cities]);
    }

    function bot(){
        $girls=Girl::select(['id','name','login','email','phone','main_image','description'])->simplePaginate(9);
        //  dump($girls);
        $current_date=Carbon::now();
        //   dump($current_date);

        $girls=Girl::select(['id','name','phone','main_image','description','sex'])
            //  ->where('vip','=','1')
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC')
            ->Paginate(9);
        //    dump($girls);
        //  dump($girls);

        $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
            ->where('beginvip','<',$current_date)
            ->where('endvip','>',$current_date)
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC')
            ->Paginate(9);
        // dump($vipGirls);
        return $girls;
       // return view('index')->with(['girls'=>$girls,'vipGirls'=>$vipGirls]);
    }

    public static function getVip(){
        $current_date=Carbon::now();
        $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description','beginvip','endvip','age'])
            //  ->where('vip','=','1')
            ->where('beginvip','<',$current_date)
            ->where('endvip','>',$current_date)
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC')
            ->Paginate(9);
          //  dump($vipGirls);
        //    echo 'test Vip';
       //echo count($vipGirls);echo '<br>';

        return $vipGirls;
    }

    public function showGirl($id)
    {

        $girl = Girl::select(['name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age','country_id','region_id','city_id','banned'])->where('id', $id)->first();
    //  dump($girl);
        if($girl==null){
            return  $this->index();
        }

        $images=Photo::select(['id','photo_name'])->where('girl_id',$id)->get();
     //   dump($images);
        //  $tags = Tag::select(['id', 'tagname'])->get();
        if($girl['country_id']!=null){
            $country=Country::select(['name'])->where('id_country',$girl['country_id'])->first();
        }
        else{
            $country=new Country();
            $country['name']="-";
        }

        if($girl['region_id']!=null){
            $region=Region::select(['name'])->where('id',$girl['region_id'])->first();
        }
        else{
            $region=new Region();
            $region['name']="-";
        }
  //  dump($girl);
        if($girl['city_id']!=null){

            $city=City::select(['id','name','id_country','id_region'])->where('id',$girl['city_id'])->first();
   //         dump($city);
            if ($city!=null){
                $id=$city->id_country;
                $country=Country::select('id_country','name')
                    ->where('id_country',$id)
                    ->first();

                $region=Region::select('id_region','name')
                    ->where('id_region',$city->id_region)
                    ->first();
         //        dump($region);
             //   dump($country);
              //  die();
            }
      //      dump($city);
          //  die();
        }
        else{
        //    echo "null";
            $city=new City();
            $city['name']="-";
         //   dump ($city);
         //   die();
        }
   //     dump($city);
     //   die();

    //   dump($country);
      //  dump($region);
    //    dump($city);
       // dump($girl);
    //    die();
        return view('girlView')->with(['girl'=>$girl,'images'=>$images,'country'=>$country,'region'=>$region,'city'=>$city]);

    }

    public function showTerms(){
        return view('usersTerm');
    }

    function createGirl(Request $request){
        $serveses=null;
     //   echo 'test';
        $user=Auth::user();
        if (Auth::guest()){
            return redirect('/login');
        }
        $girl = Girl::select(['name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age'])
            ->where('user_id', $user->id)->first();

      //  dump($girl);

        if($girl!=null){
          //  die();
            $rewest=new Request();
          return  $this->girlsShowAuchAnket($rewest);
        }

     //   dump($user);
       // die();
       // $user=Auth::user();
        if (Auth::guest()){
            return redirect('/login');
        }
        if($user->akcept==0){
            return view('rules');
        }

     //    dump($user);
        if($user->is_conferd==0)
        {
            return view('conferntEmail')->with(['email'=>$user->email]);
        }

         if($user->phone==null){
            return view('inputphone');
         }
        if($user->phone_conferd==0){
            return view('inputphone');
        }
      //  dump($user);

        //проверяем, вдруг анкета уже есть.


      //  dump($girl);

        if($girl!=null){
           return $this->index();
        }


        $phone=$user->phone;
       //  die();
        $countries=collect(DB::select('select * from countries')); //получаем страны

        //получаем регионы
        $regions=collect(DB::select('select * from regions where id_country=1')); //получаем страны

        $cities=collect(DB::select('select * from cities where id_region=1'));

        $title="Создание анкеты";
        return view('createGirl')->with(['servises' => $serveses, 'title' => $title,'phone'=>$phone,'countries'=>$countries,'regions'=>$regions,'cities'=>$cities]
        );



        //
        //  dump($serveses);
       // return view('createGirl');
    }



    public function Store(Request $request)
    {

        // для начала проверим, есть ли созданная этим юзером анкета.
           //  dump($request);

        $validatedData = $request->validate([
            'name' => 'required',

            'sex'=>'required',
            //'height'=>'required',
            'age'=>'required|numeric|min:18',
            'met'=>'required',
            'description'=>'required',
            'file'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $user=Auth::user();

        if (Auth::guest()){
            return redirect('/login');
        }

        $girl = Girl::select(['name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age'])
            ->where('user_id', $user->id)->first();

        //  dump($girl);

        if($girl!=null){
            //  die();
            $rewest=new Request();
            return  $this->girlsShowAuchAnket($rewest);
        }


            if($request->has('famele')){
                $sex='famele';
      //          echo 'famele';
            }
        if($request->has('male')){
            $sex='male';
        }

        $met=$request['met'];


        if (Input::hasFile('file')) {
          //  echo 'test';
            $image_extension = $request->file('file')->getClientOriginalExtension();
            //            dump($image_extension);
            $image_new_name = md5(microtime(true));
      //      dump($image_new_name);
            $temp_file = base_path() . '/public/images/upload/' . strtolower($image_new_name . '.' . $image_extension);// кладем файл с новыс именем

            $temp_file = base_path() . '/public/images/upload/' . strtolower($image_new_name . '.' . $image_extension);// кладем файл с новыс именем
           // echo "<br>";
          //  echo "Originan upload: ";
           // echo $temp_file;
            $request->file('file')
                ->move(base_path() . '/public/images/upload/', strtolower($image_new_name . '.' . $image_extension));
            $origin_size = getimagesize($temp_file);
        }



        $data=$request->all();
     //   dump($data);
        $girl=new Girl();
        $girl->fill($data);
        $girl['main_image']=$image_new_name. '.' . $image_extension;
        $girl['enabled']=true;
        $id=Auth::user()->id;
       // dump($id);
        $girl['user_id']=$id;
        //dump($girl);
        $girl['age']=$request['age'];
        $girl['sex']=$request['sex'];

        $girl['meet']=$request['met'];
        //встречи
        //местоположение

//dump($girl);
        if ($request->has('country')) {
            echo 'country';
            //ollect(DB::select('select price from servises where name=\'toTop\' '))->first();
            $city=$request['country'];
          //  dump($city);
            if($city!=null) {
                $girl['country_id'] = $city;
                if ($request->has('city')) {
                    echo 'city';
                    //ollect(DB::select('select price from servises where name=\'toTop\' '))->first();
                    $city=$request['city'];
//                    dump($city);

                    if($city!=null) {
                        $girl['city_id'] = $city;
                    }
                }
               if($request->has('region')){
               }
         }
        }
// регион


        $girl->save();

        if(Input::hasFile('images')){
            $count=0;
            foreach ($request->images  as $key ){
                $image_extension = $request->file('file')->getClientOriginalExtension();
                $image_new_name = md5(microtime(true));
       //         echo 'image new name ';
         //       echo $image_new_name;
                $key->move(public_path().'/images/upload/',  strtolower($image_new_name . '.' . $image_extension));
                $id=$girl['id'];
           //     echo '<br>';
             //   echo $id;
                $photo=new Photo();
                $photo['photo_name']=$image_new_name. '.' . $image_extension;
                $photo['girl_id']=$id;
                $photo->save();

            }
        }

        return redirect('/girls');

    }

    public function girlsShowAuchAnket(Request $request){
      //  dump($request);
        if(Auth::check()){
            $user=Auth::user();
            $user_id=$user->id;
            $girl=Girl::select(['id','name','login','email','phone','main_image','description','money','beginvip','endvip'])->where('user_id', $user_id)->first();
            if($girl==null){
                $requwest=new Request();
                return $this->createGirl($requwest);
            }
            $id=$girl->id;
    //    dump($girl);
            /*тут рассичаем на сколько дней уму випа хватит*/
            $price_toTop=collect(DB::select('select price from servises where name=\'toTop\' '))->first(); //получили цену
       //     dump($price_toTop);
            // $girls=Girl::select(['id','name','login','email','phone','main_image','description'])->simplePaginate(9);
            //    $user=User::select(['name', 'email', 'password','token','is_conferd','active','money','isAdmin','email_token','phone','actice_code'])->where('id',$user_id)->first();

            $money=collect(DB::select('select money from users where id=? ',[$user_id]))->first(); //получили цену
         //   dump($money);
            $maxDay=$money->money/$price_toTop->price;
            $maxDay=floor($maxDay);
          //  echo 'maxDays '; echo $maxDay;
         //       dump($maxDay);
         //   dump($user);
            $priceFirstPlase=collect(DB::select('select price from servises where name=\'toFirstPlase\' '))->first();
            $priceTop=collect(DB::select('select price from servises where name=\'toTop\' '))->first();
            $images=Photo::select(['id','photo_name'])->where('girl_id',$id)->get();
        //    dump( $priceFirstPlase);
  //          dump($user);
            return view('powerView')->with(['girl'=>$girl,'images'=>$images,'user'=>$user,'max_day'=>$maxDay,'priceFirstPlase'=>$priceFirstPlase,'priceTop'=>$priceTop]);
        }
        else{
            return redirect('/girls');
        }
    }



    public function payeer(Request $request){
       // dump($request);
        $user_id=Auth::user()->id;
        $email=Auth::user()->email;
      //  dump($email);
       // dump($user_id);

        //настройка как на сайте
        $m_shop = '604184946';
        $m_orderid = '1';
        $m_amount = number_format(100, 2, '.', '');
        $m_curr = 'RUB';
        $m_desc = base64_encode('Test');
        $m_key = 'Ваш секретный ключ';

        $arHash = array(
            $m_shop,
            $m_orderid,
            $m_amount,
            $m_curr,
            $m_desc
        );


        $arHash[] = $m_key;

        $client = new Client();

        $response = $client->request('POST', 'http://httpbin.org/post', [
            'form_params' => [
                'field_name' => 'abc',
                'other_field' => '123',
                'nested_field' => [
                    'nested' => 'hello'
                ]
            ]
        ]);
        /*
        $arParams = array(
            'success_url' => 'http://sakura.city.xsph.ru/new_success_url',
            //'fail_url' => 'http://sakura.city.xsph.ru/new_fail_url',
            //'status_url' => 'http://sakura.city.xsph.ru/new_status_url',
            'reference' => array(
                'var1' => '1',
                //'var2' => '2',
                //'var3' => '3',
                //'var4' => '4',
                //'var5' => '5',
            ),
        );

        $key = md5('Ключ для шифрования дополнительных параметров'.$m_orderid);

        $m_params = urlencode(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, json_encode($arParams), MCRYPT_MODE_ECB)));

        $arHash[] = $m_params;
        */

        $arHash[] = $m_key;

    }

    public function payeerSucces(Request $request){
            echo 'test';
    }



    public function test(Request $request){
        return view('test');
    }

    public function test2(Request $request){
        return back()->withInput();
    }

    public function reciverYandex(Request $request){
        //  echo 'yandex1';
           //  dump($request);
        //  Storage::put('/file.txt','Test');

        //  $fp = fopen(base_path().'public/request.txt', 'a');

        $date= Carbon::now();
        File::append(base_path().'/public/file.txt', 'data2'.PHP_EOL);
        File::append(base_path().'/public/file.txt','oprration_id:'. $request['operation_id'].','.'datetime: '.$request['datetime'].','.$request['sha1_hash'].','.$request['withdraw_amount'].',label:'.$request['label'].','.$date.PHP_EOL);
        // File::put(base_path().'public/file.txt.', 'data');
        //  return 'ok';
        $user_email=$request['label'];
        echo 'user email:';
           echo $user_email;
        $user_money=$request['amount'];


        //check netefication
        $operation_id=$request['operation_id'];
        if($operation_id=='test-notification'){
            try {
                DB::insert('INSERT INTO `money_history`(`date`, `user_email`, `received`,`operation_id`) VALUES (?,?,?,?)', [$date,$user_email, $user_money,'test']);
            }
            catch (IOException $exceptione){

            }
        }
        //secret: n1kUhvATa2Gf7L9jobaxlJ+t

        // $user=User::select(['name', 'email', 'password','id'])->where('email','like',$user_email)->first();
        // $user=DB::select('select * from users where email=?',[$user_email])->first();
        // $user=User::select(['id','name','email'])->where('email',$user_email);


        $user=collect(DB::select('select * from users where email like ?',[$user_email]))->first(); // работает
        //  $user2=$user[0]; // работает
          //   dump($user);
        if ($user!=null && $user_money!=null && $user_money>0){
            echo 'check money';
                   dump($user);
            $user_money_database=$user->money;
           //          dump($user_money_database);
            //      dump($user_money);
            $user_money_database+=$user_money;
            //      dump($user_money_database);
            $user->money=$user_money_database;
            DB::table('users')->where('email',$user_email)->update(['money'=>$user_money_database]);
            //     dump($user);
        }
        //  echo 'date';//dump($date);
        // вставляем историю
        try {
            DB::insert('INSERT INTO `money_history`(`date`, `user_email`, `received`,`operation_id`) VALUES (?,?,?,?)', [$date, $user_email, $user_money,$operation_id]);
        }
        catch (IOException $exceptione){

        }
        return response('OK', 200);
        //                  ->header('Content-Type', 'text/plain');

    }
    public function reciverYandexGet(Request $request){

        /*  $hash=sha1($request['notification_type'.'&'.'operation_id'.'&'.'amount'.'&'.'currency'.'&'.'datetime'.'&'.'sender'.'&'.'codepro'.'&'.'AqrFekLmxRYMOpgbkPv+TCD0'.'&'.'labe']);

          if($hash!=$request['sha1_hash'] or $request['unaccepted']===true){

          }

       File::append('YandexMoneyHistory.txt',$request['datetime'].'&recivedMoney:'.$request['amount'].'&'.'lable:'.$request['label'].PHP_EOL);
       */   File::append('YandexMoneyHistory.txt','dssd');

  //     echo 'test';
    }


    public function toFirstPlace($id){
         //   echo $id;
  // die($id);
         //   $user=collect(DB::select('select * from users where id like ?',[$id]))->first();
        $price=collect(DB::select('select price from servises where name=\'toFirstPlase\' '))->first();
       // dump($price);

        $girl=collect(DB::select('select * from girls where user_id like ?',[$id]))->first();
       //     dump($girl);

            if($girl==null){
                return redirect('/girls');
            }
     //   echo 'to firstPlase';
            // настроить списание со счета
                // проверим, достаточно ли денег на счету.
                $have_user=collect(DB::select('select money from users where id like ?',[$id]))->first();
            //    dump($have_user);
                $have_user=$have_user->money;
                $price=$price->price;
                if ($have_user>=$price){
                    $create_date=$girl->created_at;
                //    echo '<br>';
                //    echo 'create date ';
                 //   echo $create_date; echo '<br>';
                    $current_date=Carbon::now();
                  //  echo 'current date ';
                    //echo $current_date;
                 //   dump($id);
                    DB::table('girls')->where('user_id',$id)->update(['created_at'=>$current_date]);
                //    dump($girl);
              //      dump($have_user);
            //        dump($price);
            //        die();
                    //теперь списываем деньги
                    $new_money=$have_user-$price;
     //               echo 'new price '; echo $new_money;
                    DB::table('users')->where('id',$id)->update(['money'=>$new_money]);
                    $requwest=new Request();
                  return  $this->girlsShowAuchAnket($requwest);
                }
                else{
                    echo 'Недостаточно денег.';
                }
                
        $requwest=new Request();
            return  $this->index();
    }

    public function toTop(Request $request){
        //   echo $id;
   //    dump($request);
     //   echo 'в шапку';
        $id=$request['user_id'];
        //   $user=collect(DB::select('select * from users where id like ?',[$id]))->first();
        $price=collect(DB::select('select price from servises where name=\'toTop\' '))->first();
       //  dump($price);

        $girl=collect(DB::select('select * from girls where user_id like ?',[$id]))->first();
         //   dump($girl);

        if($girl==null){
            return redirect('/girls');
        }

        // настроить списание со счета
        // проверим, достаточно ли денег на счету.
        $have_user=collect(DB::select('select money from users where id like ?',[$id]))->first();
        //dump($have_user);
      //  echo 'У пользователя ';echo $have_user->money; echo '<br>';
         $user_money=$have_user->money;
        $price=$price->price;
    //    echo 'цена '; echo $price;

        if ($user_money>=$price){
//            echo 'достаточно денег';
            $create_date=$girl->created_at;
//            echo '<br>';
            $current_date=Carbon::now();
     //       echo 'current date ';
       //     echo $current_date;
            //   dump($id);


                // получем дату оканчания vip ытатуса
            $end_vip=$girl->endvip;

            $days=$request->days;
            if($end_vip==null or $end_vip<$current_date){
                    $end_vip=$current_date;
       //             echo 'новое';
     //              dump($end_vip);
                $end_vip=$this->addDayswithdate($end_vip,$days);
             //   dump($end_vip);
        //    die();

            }
            else{
       //         echo 'продление';
         //       dump($end_vip);
                $end_vip=$this->addDayswithdate($end_vip,$days);
     //           dump($end_vip);
            //    die();
            }
         //   die();
            //теперь списываем деньги
            $new_money=$have_user->money-$price*$days;
         //   dump($new_money);
        //   die();
        //    echo 'new price '; echo $new_money;
            DB::table('users')->where('id',$id)->update(['money'=>$new_money]);
            //обновляем анкету
        //    dump($girl);
      //      dump($end_vip);

            DB::table('girls')->where('id',$girl->id)->update(['endvip'=>$end_vip]);
            DB::table('girls')->where('id',$girl->id)->update(['beginvip'=>$current_date]);
        //    die();

            $requwest=new Request();
            return  $this->girlsShowAuchAnket($requwest);

        }
        else{
            echo 'Недостаточно денег.';
            $requwest=new Request();
            return  $this->girlsShowAuchAnket($requwest);
        }

        $requwest=new Request();
        return  $this->girlsShowAuchAnket($requwest);
    }

    public static function testFunction(){
        $helloTest="GekkiTest";
        return $helloTest;

    }

    public function testMail(){
        echo 'testmail';
        $testname = 'testname1';
        $mail = 'triest21@gmail.com';
        try {
            Mail::send('email.test', ['name' => $testname], function ($message) use ($mail) {
                $message
                    ->to($mail, 'some guy')
                    //->from('newmail.sm@yandex.ru')
                    ->from('sakura-testmail@sakura-city.info')
                    ->subject('Welcome');
                echo 'ok';
            });
        }
        catch (\Exception $exception){
            echo '<br>';
            echo 'error:'; echo '<br>';
           echo $exception->getMessage();
        }
    }


    function addDayswithdate($date,$days){

        $date = strtotime("+".$days." days", strtotime($date));
        return  date("Y-m-d H:i:s", $date);

    }

    public function getAdminPanel(){
        //  echo 'testAdmin ';
        $user=Auth::user();
        //  dump($user);
        //  echo '<br>';
        if($user->isAdmin==1 ){
            //   echo 'isAdmin';
            // теперь надо получить цену

            $priceFirstPlase=collect(DB::select('select price from servises where name=\'toFirstPlase\' '))->first();
            $priceTop=collect(DB::select('select price from servises where name=\'toTop\' '))->first();

            //    dump($priceFirstPlase);

            return view('AdminPanel')->with(['priceFirstPlase'=>$priceFirstPlase,'priceToTop'=>$priceTop]);;
            // return view('index');
        }
        else{
            // echo 'noAdmin';
            return redirect('/girls');
        }

        return redirect('/girls');
    }

    //устанавливаем цену за первое место:
    function SetPriceToFirstPlase(Request $request){
        //  dump($request);
        $price=$request['price'];
        $validator = Validator::make($request->all(), [
            'price' => 'required|min:0',
        ]);

        if($validator->fails()){
            return redirect('/girls');
        }

        if($price<=0){
            return redirect('/girls');
        }
        //    echo $price;

        //      DB::update('update servises set price = ? where name like \'toTop\'',$price );
        DB::update('update servises set price = ? where name = \'toFirstPlase\'',[$price]);
        return $this->getAdminPanel();

    }

    //устанавливаем цену за первое место:
    function SetPriceToTop(Request $request){
        //     dump($request);
        $price=$request['price'];
        $validator = Validator::make($request->all(), [
            'price' => 'required|min:0',
        ]);

        if($validator->fails()){
            return redirect('/girls');
        }

        if($price<=0){
            return redirect('/girls');
        }
        //   echo $price;

        //      DB::update('update servises set price = ? where name like \'toTop\'',$price );
        DB::update('update servises set price = ? where name = \'toTop\'',[$price]);
        return $this->getAdminPanel();

    }

    public function testemail(){
        // echo 'test';
        $testname='testname1';
        $mail='triest21@gmail.com';
        Mail::send('mail.test',['name'=>$testname],function ($message) use ($mail) {
            $message
                ->to($mail,'some guy')
                ->from('sakura-testmail@sakura-city.info')
                ->subject('Welcome');
        });
    }


    public function sendmail(){
        $testname='6422d6521c1a680f 79214623189';
        $mail='sms@atomic.center';
       // $mail='triest21@gmail.com';
        Mail::send('mail.sms',['name'=>$testname],function ($message) use ($mail) {
            $message
                ->to($mail,'some guy')
                ->from('sakura-testmail@sakura-city.info')
                ->subject('6422d6521c1a680f 79214623189');
        });
        echo 'senbded';
    }

    private function  SendMesageTOConfernd($token,$mail){


        Mail::send('email.confernemail',['name'=>'testname','token'=>$token],function ($message) use ($mail) {
            $message
                ->to($mail,'sope person')
                ->from('sakura.city2@yandex.ru')
                ->subject('Подтвердите адрес электронной почты');
        });
    }

    public function MailtoConfurn(){
        $user=Auth::user();
        if($user['email_token']==null) {
            $token = str_random(16);
            //  echo $token;
            DB::table('users')->where('id', $user->id)->update(['email_token' => $token]);
        }
        else{
            $token=$user['email_token'];
        }
        $mail=$user['email'];
        // echo $mail;

        Mail::send('mail.confernemail',['name'=>'testname','token'=>$token],function ($message) use ( $mail) {
            $message
                ->to($mail)
                ->from('sakura-testmail@sakura-city.info')
                ->subject('Подтвердите адрес электронной почты');
        });
        return $this->index();
    }

    public function conferndEmail($token){
        //  echo 'in condermn';
        // echo '<br>';
      //   echo $token;
        $user=User::select( 'name', 'email', 'password','token','is_conferd','active')->where('email_token',$token)->first();
      //   dump($user);


        if($user!=null) {
            // echo 'not null';
            $email=$user->email;
            //  dump($email);
            $user['is_conferd']=1;
            $user->save();
            //   dump($user);
            DB::update('update users set  	is_conferd =1 where email=?',[$email]);
            return $this->index();
        }
         else{
             return $this->index();
         }
        $requwest=new Request();
        return $this->createGirl($requwest);
    }

    public function SendSMS($phone,$text){
        $src = '<?xml version="1.0" encoding="UTF-8"?>
        <SMS>
            <operations>
            <operation>SEND</operation>
            </operations>
            <authentification>
            <username>sakura-city@rambler.ru</username>
            <password>22d2af28</password>
            </authentification>
            <message>
            <sender>SMS</sender>
            <text>'.$text.'</text>
            </message>
            <numbers>
            <number messageID="msg11">'.$phone.'</number>
            </numbers>
        </SMS>';

        $Curl = curl_init();
        $CurlOptions = array(
            CURLOPT_URL=>'http://api.atompark.com/members/sms/xml.php',
            CURLOPT_FOLLOWLOCATION=>false,
            CURLOPT_POST=>true,
            CURLOPT_HEADER=>false,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_CONNECTTIMEOUT=>15,
            CURLOPT_TIMEOUT=>100,
            CURLOPT_POSTFIELDS=>array('XML'=>$src),
        );
        curl_setopt_array($Curl, $CurlOptions);
        if(false === ($Result = curl_exec($Curl))) {
            throw new Exception('Http request failed');
        }

        curl_close($Curl);
    }

    public function rules()
    {
        return [
            'phone' => 'min:10|max:10=> \'Введите номер телефона, 10 цифр\'',

        ];
    }

    public function messages(){
        return [
            'required' => 'The :attribute field is required.'
        ];
    }

    public function inputPhone(Request $request){
        $validatedData = $request->validate([
            'phone' => 'required|digits:11|numeric',
        ]);
        if (Auth::guest()){
            return redirect('/login');
        }
        $user=Auth::user();
        $phone=$request['phone']; //dump($phone);
        //тут попробуем проверить, что=бы первая цифра была 7;
         $firstlettst= substr($phone, 0, 1);
       //  echo $firstlettst;

         if($firstlettst==8){
             $phone=substr_replace($phone, 7, 0, 1);
         }
      //   echo $phone;
    //     die();

     //   dump($phone);
        //проверяем, есть ли пользователь с этим телефоном;
        //   $user=User::select( 'name', 'email', 'password','token','is_conferd','active')->where('email_token',$token)->first();
   //     echo "eser vith this phone";
        $user_with_this_phone=User::select( 'id' ,'name', 'email', 'password','token','is_conferd','active','money','isAdmin','email_token','phone','phone_conferd','actice_code','akcept')->where('phone',$phone)->first();
     //   dump($user_with_this_phone);
//        dump($user);

        if($user_with_this_phone!=null) {
            if ($user_with_this_phone->email != $user->email and $user_with_this_phone->phone_conferd == 0) {
             //   echo "не этот пользовател и его номер не подтвержден";
                DB::table('users')->where('email', $user_with_this_phone->email)->update(['phone' => NULL]);
                $user = Auth::user();
                //    dump($user);
                $id = $user->id;

                DB::table('users')->where('id', $id)->update(['phone' => $phone]);
                $activeCode = rand(1000, 9999);
                //      echo $activeCode;
                DB::update('update users set actice_code = ? where id = ?', [$activeCode, $id]);

            //    echo "active cod ";
              //  echo $activeCode;
             //   echo "<br>";
              //  echo "phone ";
               // echo $phone;
                 $this->sendSMS($phone,$activeCode);

                return view('inputactivecode');
            } elseif ($user_with_this_phone->email != $user->email and $user_with_this_phone->phone_conferd == 1) {
               // echo "не этот пользовател и его номер  подтвержден";
                $validatedData = $request->validate([
                    'phone' => 'required|digits:11|numeric|unique:users',
                ]);

            }
        }
      //  die();
        // $have_user=collect(DB::select('select money from users where id like ?',[$id]))->first();
        $phoneinbase=collect(DB::select('select phone from users where id=?',[$user->id]))->first();
      //  echo "phone in base ";
      //  dump($phoneinbase);
        if($phoneinbase->phone!=null){
        //    echo 'phone is not null';echo "<br>";
            $activecod=collect(DB::select('select actice_code from users where id=?',[$user->id]))->first();
        //         echo "phone";echo $phone;echo "<br>";
         //   echo "code";echo $activecod->actice_code;echo "<br>";
            echo "sending SMS";echo "<br>";
         //  dump($activecod);
            $this->sendSMS($phone,$activecod->actice_code);
            return view('inputactivecode');
        }
         else{
             if (Auth::guest()){
                 return redirect('/login');
             }
             $user=Auth::user();
             //    dump($user);
             $id=$user->id;

             DB::table('users')->where('id',$id)->update(['phone'=>$phone]);
             $activeCode= rand (1000, 9999 );
             //      echo $activeCode;
             DB::update('update users set actice_code = ? where id = ?',[$activeCode,$id]);

              //  echo "active cod ";echo $activeCode;echo "<br>";echo "phone ";echo $phone;
             $this->sendSMS($phone,$activeCode);

             return view('inputactivecode');
         }




    }

    public function inputActiveCode(Request $request){
     //   dump($request);
        $code=$request['code'];
        if (Auth::guest()){
            return redirect('/login');
        }
        $user=Auth::user();
      //  dump($user);
        $id=$user->id;
        //    $have_user=collect(DB::select('select money from users where id like ?',[$id]))->first();
        $user_code=collect(DB::select('select actice_code from users where id like ?',[$id]))->first();
       // dump($user_code);
     //   dump($code);
        $code=(int)$code;
      //  dump($code);
      //  dump($user_code);
         //die();
        //$price=$price->price;
       $user_code=$user_code->actice_code;

        if($code==$user_code){
     //       echo 'cade actice ';

            DB::update('update users set phone_conferd  = 1 where id = ?',[$id]);
            return $this->index();
        }
        else{
            echo 'code actice false';
            return view("inputphone");
        }

    }

    public function akceptRules(Request $request){
        if (Auth::guest()){
            return redirect('/login');
        }
        $user=Auth::user();

        if($user==null){
            return redirect('/login');
        }


        $email=$user->email;
        if($email==null){
            return $this->index();
        }
/*
        try {
            DB::update('update users set  akcept=1 where email=?', [$email]);
        }
            catch (\Exception $exception){
                return $this->index();
            }*/
        DB::table('users')->where('id',$user->id)->update(['akcept'=>1]);
        $user=Auth::user();

        $requwest=new Request();

        //    dump($user);
        if($user->is_conferd==0)
        {
            return view('conferntEmail')->with(['email'=>$user->email]);
        }

        if($user->phone==null){
            return view('inputphone');
        }
        if($user->phone_conferd==0){
            return view('inputphone');
        }

        $girl = Girl::select(['name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age'])
            ->where('user_id', $user->id)->first();
        //  dump($girl);

        if($girl!=null){
            return $this->index();
        }


        $phone=$user->phone;
        //  die();
            $serveses=null;
        $title="Создание анкеты";
        return view('createGirl')->with(['servises' => $serveses, 'title' => $title,'phone'=>$phone]);
      // return $this->createGirl($requwest);

    }

    public function girlsEditAuchAnket(){
      //  dump($girl_id);

        if (Auth::guest()){
            return redirect('/login');
        }
        $user=Auth::user();
        if($user==null){
            return redirect('/login');
        }

        $girl = Girl::select(['name','age', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','country_id','region_id','city_id'])->where('user_id', $user->id)->first();
         if ($girl==null){
             return $this->index();
         }
    //  dump($girl);
       $phone=$user->phone;
      //  $images=Photo::select(['id','photo_name'])->where('girl_id',$girl_id)->get();
      //  dump($images);
        //  $tags = Tag::select(['id', 'tagname'])->get();
        $countries=collect(DB::select('select * from countries'));
        $regions=collect(DB::select('select * from regions'));

        //   DB::update('update users set phone_conferd  = 1 where id = ?',[$id]);
        $country=collect(DB::select('select * from countries where id_country=?',[$girl->country_id]))->first(); //получаем страны
      //  $country=$country[0];
    //   dump($country);
         //получаем регионы
        $region=collect(DB::select('select * from regions where id=?',[$girl->region_id]))->first(); //получаем страны
      //  dump($region);
       // die();
       // $regions=collect(DB::select('select * from regions where id_country=?',[$girl->country_id]));
      // dump($region);
        $city=collect(DB::select('select * from cities where id=?',[$girl->city_id]))->first();

        $cityes=collect(DB::select('select * from cities where id_region=?',[$girl->region_id]));
     //   dump($cityes);
     //   dump($city);
      //  dump($regions);

        return view('editGirl')->with(['girl'=>$girl,'phone'=>$phone,'countries'=>$countries,'country'=>$country,'regions'=>$regions,'cityes'=>$cityes]);
    }

    public function edit(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'age'=>'required',
            'sex'=>'required',
            //'height'=>'required',

            'met'=>'required',
            'description'=>'required',

        ]);
    //    dump($request);
      //  die();
        if (Auth::guest()){
            return redirect('/login');
        }
        $user=Auth::user();
        if($user==null){
            return redirect('/login');
        }
        $girl = Girl::select(['name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height'])->where('user_id', $user->id)->first();

        if($girl==null){
            return redirect('/index');
        }
   //     dump($girl);

        //   die();
        if($request->has('famele')){
            $sex='famele';
        //    echo 'famele';
        }
        if($request->has('male')){
            $sex='male';
          //  echo 'male';
        }

        //   dump($request);


        //DB::table('users')->where('id',$user->id)->update(['email_token'=>$token]);
        //
       DB::table('girls')->where('id',$girl->id)->update(['age'=>$request['age']]);
        DB::table('girls')->where('id',$girl->id)->update(['sex'=>$request['sex']]);
        DB::table('girls')->where('id',$girl->id)->update(['meet'=>$request['met']]);
        DB::table('girls')->where('id',$girl->id)->update(['description'=>$request['description']]);


        //тут смотрим картинку
     //   die();
       //  $request=new Request();
        if (Input::hasFile('file')) {
          //    echo 'test';
             /*
              *  File::Delete($temp_file);
              */
             $old_image_name=$girl['main_image'];
          //   echo $old_image_name;
             $path=base_path() . '/public/images/upload/'.$old_image_name;
            // echo $path;
             File::Delete($path);

            $image_extension = $request->file('file')->getClientOriginalExtension();
            //            dump($image_extension);
            $image_new_name = md5(microtime(true));
            //      dump($image_new_name);

            $temp_file = base_path() . '/public/images/upload/' . strtolower($image_new_name . '.' . $image_extension);// кладем файл с новыс именем
         //   echo '<br>';
           // echo 'temp file';
           // echo $temp_file;

            // echo "<br>";
            //  echo "Originan upload: ";
            // echo $temp_file;
             $new_name=$image_new_name . '.' . $image_extension;
           //  echo 'new name '.$new_name;
            $request->file('file')
                ->move(base_path() . '/public/images/upload/', strtolower($image_new_name . '.' . $image_extension));

            DB::table('girls')->where('id',$girl->id)->update(['main_image'=>$new_name]);
            $origin_size = getimagesize($temp_file);

        }


    if($request->has('change')) {
        //тут местоположее
        if ($request->has('city')) {
            // echo 'city';
            //  dump($request);
            // die();
            if ($request['city'] != null) {
                //  die();
                //ollect(DB::select('select price from servises where name=\'toTop\' '))->first();
                //  $city = null;
                $city = $request['city'];
          #      dump($city);
                //   die();
                DB::table('girls')->where('id', $girl->id)->update(['city_id' => $city]);
            }
        }
        if ($request->has('country')) {
            //     echo 'country';
            //ollect(DB::select('select price from servises where name=\'toTop\' '))->first();
            $country = $request['country'];
          #  dump($country);
            if ($country == "-") {
                $country = null;
            }

            DB::table('girls')->where('id', $girl->id)->update(['country_id' => $country]);


        }
        if ($request->has('region')) {
            //   echo 'region';
            //ollect(DB::select('select price from servises where name=\'toTop\' '))->first();
            $city = $request['region'];
            //     dump($city);
            if ($city != null) {
                $girl['region_id'] = $city;
            }
            DB::table('girls')->where('id', $girl->id)->update(['region_id' => $request['region']]);


        }
    }
      return $this->girlsEditAuchAnket();
    }

    public function inputPhone2(){
        return view('inputPhone2');
    }

        //галерея
    public function galarayView(Request $request){
        $user=Auth::user();
        if (Auth::guest()){
            return redirect('/login');
        }

      //  dump($user);
        if ($user==null){
            return redirect('/login');
        }


        $girl = Girl::select(['id','name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age'])->where('user_id', $user->id)->first();
        //    dump($girl);
        if($girl==null){
            return  $this->index();
        }

        $images=Photo::select(['id','photo_name'])->where('girl_id',$girl->id)->get();

    //    dump($images);

        return view('editImage')->with(['girl'=>$girl,'images'=>$images]);

    }

    public function deleteImage($id){
      //  dump($id);
        $user=Auth::user();
        if (Auth::guest()){
            return redirect('/login');
        }

    //    dump($user);
        if ($user==null){
            return redirect('/login');
        }


        $girl = Girl::select(['id','name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age'])->where('user_id', $user->id)->first();
        //    dump($girl);
        if($girl==null){
            return  $this->index();
        }
        $temp_file = base_path() . '/public/images/upload/'.$id;// кладем файл с новыс именем
       // dump($temp_file);

        try{
            $temp_file = base_path() . '/public/images/upload/'.$id;
            File::Delete($temp_file);
            print($id);
           // тут будем удалять из таблицы
            $photo=Photo::select('id')->where('photo_name',$id)->get();
          //  dump($photo);

            $photo->delete();

        }
        catch (\Exception $e) {
            echo "delete errod";
        }

        $image=Photo::select(['id','photo_name'])->where('photo_name',$id)->first();
        try {
            File::delete($id);
        }
        catch (IOException $e){

        }
      //  dump($image);
        $image->delete();
        $requwest=new Request();
        return $this->galarayView( $requwest);

    }

    public function uploadimage(Request $request){
       // dump($request);

        $validatedData = $request->validate([
            'file'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);



        $user=Auth::user();
        if (Auth::guest()){
            return redirect('/login');
        }
    //    dump($user);
        if ($user==null){
            return redirect('/login');
        }
        $girl = Girl::select(['id','name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age'])->where('user_id', $user->id)->first();
        //    dump($girl);
        if($girl==null){
            return  $this->index();
        }
   //     dump($request);

        if (Input::hasFile('file')) {
            //  echo 'test';
            $image_extension = $request->file('file')->getClientOriginalExtension();
            //            dump($image_extension);
            $image_new_name = md5(microtime(true));
            //      dump($image_new_name);
            $temp_file = base_path() . '/public/images/upload/' . strtolower($image_new_name . '.' . $image_extension);// кладем файл с новыс именем

            $temp_file = base_path() . '/public/images/upload/' . strtolower($image_new_name . '.' . $image_extension);// кладем файл с новыс именем
            // echo "<br>";
            //  echo "Originan upload: ";
            // echo $temp_file;
            $request->file('file')
                ->move(base_path() . '/public/images/upload/', strtolower($image_new_name . '.' . $image_extension));
            $origin_size = getimagesize($temp_file);

            $photo=new Photo();
            $girl=Girl::select('id')->where('user_id',$user->id)->first();
            $photo['photo_name']=$image_new_name . '.' . $image_extension;
            $photo['girl_id']=$girl->id;
            //получаем id девушки
           $photo->save();
        }

        $requwest=new Request();
        return $this->galarayView( $requwest);


    }



    public function prodfunct(){

        $prod=ProductCat::all();//get data from table
        return view('productlist',compact('prod'));//sent data to view

    }

    public function findProductName(Request $request){

    //    dump($request);
        //if our chosen id and products table prod_cat_id col match the get first 100 data

        //$request->id here is the id of our chosen option id
        $data=Product::select('productname','id')->where('prod_cat_id',$request->id)->take(100)->get();
        return response()->json($data);//then sent this data to ajax success
    }

    public function findRegions($id){


       // $id=$request->id;
      //  $id=Input::get('country_id');
    //    dump($id);
        //   $user_code=collect(DB::select('select actice_code from users where id like ?',[$id]))->first();
      // $cities=collect(DB::select('select name from region where id_country like ?',[$id]))->take(100);
        $regions=Region::select('name')
            ->where('id_country',$id)
            ->orderBy('id_region ','ASC')
            ->get();

      //dump($regions);
      return Response::json($regions);
     // $regions2=json_encode($regions);
      //dump($regions2);

      //  return response()->json(['regions'=>$regions]);//then sent this data to ajax success
    }

    public function findPrice(Request $request){

        //it will get price if its id match with product id
        $p=Product::select('price')->where('id',$request->id)->first();

        return response()->json($p);
    }

    public function getSearch(){

        //     $price_toTop=collect(DB::select('select price from servises where name=\'toTop\' '))->first(); //получили цену
        //
        $price=collect(DB::select('select price from servises '));

        $countries=collect(DB::select('select * from countries')); //получаем города

         //dump($countries);

 //->with(['girl'=>$girl,'images'=>$images]);
        return view('cityes')->with(['countries'=>$countries]);;
    }

    public function search(Request $request){
        //dump($request);
        $current_date=Carbon::now();
        if($request['country']=='-') {
            $girls=Girl::select(['id','name','login','email','phone','main_image','description'])->simplePaginate(9);
            $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
                ->where('beginvip','<',$current_date)
                ->where('endvip','>',$current_date)
                ->orderBy('created_at','DESC')
                ->orderBy('rating','ASC')
                ->Paginate(9);
            // dump($vipGirls);
            $countries=collect(DB::select('select * from countries')); //получаем страны

            //получаем регионы
            $regions=collect(DB::select('select * from regions where id_country=1')); //получаем страны

            $cities=collect(DB::select('select * from cities where id_region=1'));
            return view('index2')->with(['girls'=>$girls,'vipGirls'=>$vipGirls,'countries'=>$countries,'regions'=>$regions,'cities'=>$cities]);

          //  die();
        }
        if($request['city']!=null){
           $girls=Girl::select(['id','name','login','email','phone','main_image','description','sex'])
               ->where('city_id',$request['city'])
               ->orderBy('rating','ASC')
               ->Paginate(9);
            $current_date=Carbon::now();
            $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
                ->where('beginvip','<',$current_date)
                ->where('endvip','>',$current_date)
                ->orderBy('created_at','DESC')
                ->orderBy('rating','ASC')
                ->Paginate(9);
            $countries=collect(DB::select('select * from countries')); //получаем страны

            //получаем регионы
            $regions=collect(DB::select('select * from regions where id_country=1')); //получаем страны
            $cities=collect(DB::select('select * from cities where id_region=1'));
            return view('index2')->with(['girls'=>$girls,'vipGirls'=>$vipGirls,'countries'=>$countries,'regions'=>$regions,'cities'=>$cities]);
        }

        if($request['region']!=null){

            $girls=Girl::select(['id','name','login','email','phone','main_image','description','sex'])
                ->where('region_id',$request['region'])
                ->orderBy('rating','ASC')
                ->Paginate(9);

         //   die();
            $current_date=Carbon::now();
            $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
                ->where('beginvip','<',$current_date)
                ->where('endvip','>',$current_date)
                ->orderBy('created_at','DESC')
                ->orderBy('rating','ASC')
                ->Paginate(9);
            $countries=collect(DB::select('select * from countries')); //получаем страны

            //получаем регионы
            $regions=collect(DB::select('select * from regions where id_country=1')); //получаем страны

            $cities=collect(DB::select('select * from cities where id_region=1'));
            return view('index2')->with(['girls'=>$girls,'vipGirls'=>$vipGirls,'countries'=>$countries,'regions'=>$regions,'cities'=>$cities]);
        }

        $girls=Girl::select(['id','name','login','email','phone','main_image','description','sex'])
            //  ->where('vip','=','1')
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC')
            ->Paginate(9);
        //    dump($girls);
        //  dump($girls);

        $vipGirls=Girl::select(['id','name','login','email','phone','main_image','description'])
            ->where('beginvip','<',$current_date)
            ->where('endvip','>',$current_date)
            ->orderBy('created_at','DESC')
            ->orderBy('rating','ASC')
            ->Paginate(9);
        // dump($vipGirls);

        return view('index2')->with(['girls'=>$girls,'vipGirls'=>$vipGirls]);

     //   die();
        }

        public function adminToGirl(Request $request){
            //dump($request);
            if ($request->has('banned'))
                $banned=1;
            else{
                $banned=0;
            }
            $girl = Girl::select(['name', 'email', 'password','id','phone','description','enabled','payday','payed','login','main_image','sex','meet','weight','height','age','country_id','region_id','city_id','banned'])->where('id', $request->girl)->first();
            $girl->banned=$banned;
            $girl->save();

            //теперь сообщение
            if ($request->description!=null) {
                $message = new Message();
                $message->text = $request->description;
                $message->girl_id = $request->girl;
                $message->fromAdmin = 1;
                $message->save();
            }

          //  return back();
            return $this->showGirl($girl->id);
          //  die();

}

        public function getMessagePage(){
            if (Auth::guest()){
                return redirect('/login');
            }
            $user=Auth::user();

            $girl = Girl::select(['id','name'])
                ->where('user_id', $user->id)->first();

//            dump($girl);

            $messages=Message::select( 'id','text','girl_id','fromAdmin','date','readed')
                ->where('girl_id',$girl->id)
                 ->orderBy('created_at')
            ->get();
            //dump($messages);
            foreach ($messages as $message){
                if($message->fromAdmin==1){
                    $message->readed=1;
                    $message->save();
                }
            }
             return view('messages')->with(['messages'=>$messages,'girl'=>$girl]);
        }

    public function getMessagePageAdmin($girl_id){
        if (Auth::guest()){
            return redirect('/login');
        }
        $user=Auth::user();

        $girl = Girl::select(['id','name'])
            ->where('id', $girl_id)->first();

//            dump($girl);

        $messages=Message::select( 'id','text','girl_id','fromAdmin','date','readed','adminreaded')
            ->where('girl_id',$girl->id)
            ->orderBy('created_at')
            ->get();

        //dump($messages);
        foreach ($messages as $message){
            if($message->fromAdmin==1){
                $message->readed=1;
                $message->save();
            }
        }
        foreach ($messages as $message){
             $message->adminreaded=1;
             $message->save();
            }

        return view('messages')->with(['messages'=>$messages,'girl'=>$girl]);
    }


        public function girlToAdmin(Request $request){
            $validatedData = $request->validate([
                'girl'=>'required',
                'description'=>'required'
            ]);
            if (Auth::guest()){
                return redirect('/login');
            }
            //dump($request);
            $message=new Message();
            $message->text=$request->description;
            $message->girl_id=$request->girl;
            $message->fromAdmin=0;
            $message->adminreaded=0;
            $message->readed=0;
            $message->save();
            return $this->getMessagePage();
        }

        public function usersList(Request $request){



        }


         public function messagesList(Request $request){
              /*  $messages=Message::select( 'id','text','girl_id','fromAdmin','date','readed')
                    ->groupBy('girl_id')
                    ->orderBy('created_at')
                    ->get();
                dump($messages);*/
                //collect(DB::select('select * from countries'));
               // $quewery=collect(DB::select('SELECT id,text,girl_id,date FROM `messages`'));
             $messages=Message::select(['id','text','girl_id','date','adminreaded'])
                 //->groupBY('girl_id')
                 ->orderBY('date','desc','girl_id')
                 ->get()
                 ->unique('girl_id')
             ;
             $user=Auth::user();
             if ($user==null){
                 return $this->index();
             }
             //  dump($user);
             //  echo '<br>';
             if($user->isAdmin==0 or $user==null )
             {
                 return $this->index();
             }

        //   dump($messages);
              //  dump($quewery);
             //   return view('createGirl')->with(['servises' => $serveses, 'title' => $title,'phone'=>$phone,'countries'=>$countries,'regions'=>$regions,'cities'=>$cities]
             //

                return view('messages-list')->with(['messages'=>$messages]);

      }

      public function moneyHistory(Request $request){
          $user=Auth::user();
          if ($user==null){
              return $this->index();
          }
          //  dump($user);
          //  echo '<br>';
          if($user->isAdmin==0 or $user==null )
          {
              return $this->index();
          }
                //       $price_toTop=collect(DB::select('select price from servises where name=\'toTop\' '))->first(); //получили цену
          $history=collect(DB::select('SELECT * FROM `money_history` ORDER BY `date` DESC '));  //получаем страны
          $history=$history->paginate(50);
          dump ($history);
      }


      public function SendResetSMS($phone){

            dump($phone);
      

          return Response::json([
              'phone' => $phone,
          //    'user' => $user->name
            //  'name'=>$name
          ]);
      }


}
