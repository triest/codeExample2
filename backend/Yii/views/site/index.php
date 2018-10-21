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
                                <h6>Категория: <a href="#"><?=$article->category->title ?></a> </h6>
                                <div class="entry-title"><?=$article->title ?></div>
                            </header>

                            <div class="social-share">
                                <span class="social-share-title pull-left text-capitalize">By </span>
                                <span class="social-share-title pull-left text-capitalize">  <span class="p-date"><?=$article->getDate() ?> </span><br> </span>
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
            <div class="col-md-4" data-sticky_column="">
                <aside class="widget">
                    <b>Популярные посты:</b>
                    <?php foreach ($popular as $article):?>
                            <div class="popular-post">
                                <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>"><img src="<?= $article->getImage();?>" alt=""></a>
                                <div class="entry-title"><?=$article->title ?></div>
                                <div class="entry-title"><?=$article->date ?></div>
                            </div>
                     <?php endforeach; ?>
                </aside>
                <aside class="widget">
                    <b>Посдедние посты:</b>
                    <?php foreach ($recent as $article):?>
                        <div class="popular-post">
                            <a href="<?= Url::toRoute(['site/view', 'id'=>$article->id]);?>"><img src="<?= $article->getImage();?>" alt=""></a>
                            <div class="entry-title"><?=$article->title ?></div>
                            <div class="entry-title"><?=$article->date ?></div>
                        </div>
                    <?php endforeach; ?>
                </aside>
                <aside class="widget border pos-padding">
                    <b>Популярные категории:</b>
                    <?php foreach ($categories as $category):?>
                        <div class="popular-post">
                           <a href="#"><?=$category->title ?></a>
                            <span class="post-count"><?=$category->getArticleCount() ?></span>
                        </div>
                    <?php endforeach; ?>
                </aside>
            </div>
        </div>
    </div>
</div>
