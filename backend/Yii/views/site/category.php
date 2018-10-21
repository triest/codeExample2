<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($articles as $article):?>
                    <article class="post">
                        <div class="post-thumb">
                            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>"><img src="<?= $article->getImage();?>" alt=""></a>

                            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center">View Post</div>
                            </a>
                        </div>
                        <div class="post-content">
                            <header class="entity-header text-center text-uppercase ">
                                <h6><a href="#"><?=$article->category->title ?></a> </h6>
                                <div class="entry-title"><?=$article->title ?></div>
                            </header>
                            <div class="entry-content">
                                <p>
                                    <?=$article->description ?>

                            </div>
                            <div class="social-share">
                                <span class="social-share-title pull-left text-capitalize">By </span>
                                <ul class="text-center pull-right">
                                    <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li><?= (int) $article->viewed?>
                                </ul>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php

                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>

            </div>
        </div>
    </div>
</div>
