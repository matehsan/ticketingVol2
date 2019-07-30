<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1 style="font-family: Samim"> خوش آمدید</h1>

        <p class="lead">سامانه ی ارسال تیکت به پشتیبانی.</p>
        <?php if (Yii::$app->user->isGuest){
            echo Html::a('ابتدا وارد شوید','?r=site%2Flogin',['class' => 'btn btn-lg btn-success']);
    }else{
            echo  '<p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>';

        }

    ?>
    </div>


</div>
