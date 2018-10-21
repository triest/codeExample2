<?php
use yii\helpers\Url;
?>
<!--main content start-->
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                       <img src="<?= $article->getImage();?>" alt="">
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute(['site/category','id'=>$article->category->id])?>"> <?= $article->category->title?></a></h6>
                            <h1 class="entry-title"><?= $article->title?></h1>
                        </header>

                        <div class="entry-content">
                            <?= $article->content ?>
                        </div>
                        Теги:
                        <?php foreach ($tags as $tag):?>
                          <?php $tag->title ?>
                        <?php endforeach; ?>
                        <br>
                        <?php
                        use yii\helpers\Html;
                        use yii\widgets\ActiveForm;
                        ?>
                        <?php if(Yii::$app->user->isGuest):?>
                        <?php else: ?>
                        <?php $form = ActiveForm::begin() ?>
                        <?= $form->field($commentForm, 'comment') ?>
                        <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
                        <?php ActiveForm::end() ?>
                        <?php endif; ?>

                        Комментарии: <br>
                        <?php foreach ($article->comments as $comment):?>
                            <div class="bottom-comment">
                                <div class="comment-text">
                                    <h5><?= $comment->user->name?></h5>
                                </div>
                                <div class="comment-date"><?= $comment->date?></div>
                                <div class="para"><?= $comment->text?></div>
                            </div>
                        <?php endforeach; ?>


                        <div class="social-share">
							<span

                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </article>


        </div>
    </div>
</div>
<!-- end main content-->