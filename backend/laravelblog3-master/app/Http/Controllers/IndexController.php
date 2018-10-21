<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;
use App\Tag;
use App\Comment;
use function Symfony\Component\VarDumper\Tests\Caster\reflectionParameterFixture;
//use Zend\InputFilter\Input;
use Illuminate\Support\Facades\Input;
use Auth;
use Illuminate\Contracts\Auth\Guard;

use App\Repositories\ImageRepository;
use Validator;

use File;
use Illuminate\Foundation\Validation\ValidatesRequests;
use \Eventviva\ImageResize;

class IndexController extends Controller
{
    //
    protected $message;
    protected $header;
    public function __construct(){
           $this->header='Hello word';
           $this->message='message';
    }

    public function index(){

        $articles=Article::select(['id','title','desc','created_at','image_file'])->get();

        // $articles=$articles->paginate(2)
    //    dump($articles);
        $tags=Tag::select(['id','tagname'])->get();
        dump($tags);
        return view('page')->with(['message'=>$this->message,
                    'header'=>$this->header,
                'articles'=>$articles,
                'tags'=>$tags]
        );
    }
    //оригинал

    public function tagSearch($request){

        $articles=Article::select(['id','title','desc','created_at'])->where('tag',$request)->get();
        $tags=Tag::select(['id','tagname'])->get();
        dump($tags);
        return view('page')->with(['message'=>$this->message,
                'header'=>$this->header,
                'articles'=>$articles,
                'tags'=>$tags]
        );
    }

    public function show($id) {

        $article = Article::select(['id','title','text','image_file'])->where('id',$id)->first();
        dump($article);
        $tags=Tag::select(['id','tagname'])->get();


        //получаем комментари
        $comments=Comment::select(['author','text','post_id','date'])
            ->where('post_id',$id)
            ->orderBy('date','desc')
            ->get();
        dump($comments);
    //    dump($tags);
        return view('article-content')->with(['message'=>$this->message,
            'header' => $this->header,
            'article' => $article,
            'tags'=>$tags,
            'comments'=>$comments,
            'id'=>$id
        ]);

    }

    public function delete($id){
        if (Auth::check()) {
        $article = Article::select(['id','title','text'])->where('id',$id)->first();
        $article->delete();
    }

        else{
            return view('auth/login');
        }
        return $this->index();
    }

    public function deleteTeg($id){
        if (Auth::check()) {
            $teg = Tag::select(['id', 'tagname'])->where('id', $id)->first();
            $teg->delete();

            $tags = Tag::select(['id', 'tagname'])->get();
            return view('add-tag')->with(['tags' => $tags]);
        }
        else{
            return view('auth/login');
        }
    }

    public function add(){
        if (Auth::check()) {
            // The user is logged in...

            $tags = Tag::select(['id', 'tagname'])->get();

            return view('add-content')->with(['message' => $this->message,
                    'header' => $this->header,
                    'tags' => $tags
                ]

            );
        }
        else{
            return view('auth/login');
        }
    }

    public function tagPageAdd(){
            $tags=Tag::select(['id','tagname'])->get();
            dump($tags);
        return view('add-tag')->with(['tags'=>$tags]);
    }

    public function tagStore(Request $request){
        if (Auth::check()) {
        $data=$request->all();
      /*  dump($data);*/
       $teg=new Tag();
        $teg->fill($data);

       $teg->save();
        }
        else{
            return view('auth/login');
        }
        return $this->tagPageAdd();
    }



    public function store(Request $request){
        dump($request->all());
        $validator =Validator::make($request->all(),[
            //'title'=>'required|max:255',
         //   'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
           // 'text'=>'required',
        ]);
  /*     if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }
*/


  if ($request->has('image_file')){
      $image_extension = $request->file('image_file')->getClientOriginalExtension();
       dump($image_extension);
        $image_new_name = md5(microtime(true));
        dump($image_new_name);
        $temp_file = base_path() . '/public/images/upload/'.strtolower($image_new_name . '.' . $image_extension);// кладем файл с новыс именем

      $request->file('image_file')
            ->move( base_path() . '/public/images/upload/', strtolower($image_new_name . '.' . $image_extension) );

        $origin_size = getimagesize( $temp_file );
      }
           $data=$request->all();
       //  dump($data);

           $aticle=new Article;
           $aticle->fill($data);
        //   dump($aticle);
           $aticle->save();
          return $this->index();

         //  return view('page');

    }

    public function addComment(Request $request){
        /*    dump($request->all());*/
            $data=$request->all();
            $comment=new Comment();
            $comment->fill($data);
            $comment['date']=date('Y-m-d H:i:s');
            dump($comment);
           $comment->save();
          /*  return $this->index();*/
        //  dump($comment);
    }


}
