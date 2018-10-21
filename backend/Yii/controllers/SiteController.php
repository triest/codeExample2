<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\Comment;
use app\models\CommentForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
       $data=Article::getAll(5);
       $popular=Article::getPopular();
       $recent=Article::getRecent();
       $categories=Category::gatAll();
        return $this->render('index',
            [
                'articles'=>$data['articles'],
                'pagination'=>$data['pagination'],
                'popular'=>$popular,
                'recent'=>$recent,
                'categories'=>$categories
            ]);
    }



    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionView($id){



        $article=Article::findOne($id);
      //  var_dump($article);
     //   die();
         $tags=$article->tags;
       // $comments = Comment::find()->where('article_id',$article->id);
         //   $comments=None;
        $comments=$article->comments;

     //   $commentsCount=Comment::find()->where('article_id',$id);

      //  die();
        $commentForm = new CommentForm();
        if(Yii::$app->request->isPost){
            if( $commentForm->load(Yii::$app->request->post())) {
                if ( $commentForm->saveComment($id)) {
                    return $this->redirect(['site/view', 'id' => $id]);
                }
            }
        }
        return $this->render('single',[
            'article'=>$article,
            'tags'=>$tags,
            'comments'=>$comments,
            'commentForm'=>$commentForm
        ]);
    }

    public function actionCategory($id){

        $query=Article::find()->where(['category_id'=>$id]);

        // build a DB query to get all articles with status = 1

// get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

// create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count,'pageSize'=>5]);

// limit the query using the pagination and retrieve the articles
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['articles']=$articles;
        $data['pagination']=$pagination;

        $popular=Article::find()->orderBy('viewed desc')->all();

        return $this->render('category',
            [
                'articles'=>$data['articles'],

                'pagination'=>$data['pagination'],
                'popular'=>$popular
            ]);

    }

    public function actionComment($id){
        $model=new CommentForm();
     //   die();
        if(Yii::$app->request->isPost){
          if($model->load(Yii::$app->request->post())) {
              var_dump(Yii::$app->request->post());

              if ($model->saveComment($id)) {
                  return $this->redirect(['site/view', 'id' => $id]);
              }
          }
        }

    }
}
