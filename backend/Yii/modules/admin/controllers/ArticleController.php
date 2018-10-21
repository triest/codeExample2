<?php

namespace app\modules\admin\controllers;

use app\models\Category;
use app\models\ImageUpload;
use app\models\Tag;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSetImage($id){
        $model=new ImageUpload();


        if(Yii::$app->request->isPost){
            $article=$this->findModel($id);
           $file=UploadedFile::getInstance($model,'image');
        //   var_dump(md5(uniqid($file->baseName)).'.'.$file->extension);
       //    $model->uploadFile($file);
         //  $model->save();
           //die();
        if($temp=$article->saveImage($model->uploadFile($file,$article->image))){
            return $this->redirect(['view','id'=>$article->id]);
        }

        }

        return $this->render('image',['model'=>$model]);

        //die('image upload page');
    }

     public function deleteImage(){
        $imageeUpload=new ImageUpload();
        $imageeUpload->deleteCurrentImage($this->image);
     }

     public function beforeDelete(){
        $this->deleteImage();
        return parent::beforeDelete();
     }

     public function actionSetCategory($id){
        $article=$this->findModel($id);
        $selectedCategory=$article->category->id;
         $categoties=ArrayHelper::map(Category::find()->all(), 'id', 'title');
       //  var_dump($categoties);die();
         if(Yii::$app->request->isPost){
            $id=Yii::$app->request->post('category');
            $article->saveCategory($id);

             return $this->redirect(['view','id'=>$article->id]);

         }

        return $this->render('category',[
            'article'=>$article,
            'selectedCategory'=>$selectedCategory,
            'categories'=>$categoties
        ]);
       // var_dump($article->title);
       // echo '<br>';
      // echo $article->category->title;
     //   die();
     }

     public function actionSetTags($id){
        $article=$this->findModel($id);
      //  var_dump($article->tags);
        $selectedTags=$article->getSelectedTags();
       // var_dump($selectedTags);
        $tags=ArrayHelper::map(Tag::find()->all(), 'id', 'title');
       // var_dump($tags);
     //   die();
         if(Yii::$app->request->isPost){
         //    var_dump(Yii::$app->request);
            $tags=Yii::$app->request->post('tags');
          //  var_dump($tags);
             $article->saveTags($tags);
          //  die();
          //   die("posttags");
             return $this->redirect(['view', 'id'=>$article->id]);
         }

        return $this->render('tags',['article'=>$article,'selectedTags'=>$selectedTags,
            'tags'=>$tags]);
     }

}
