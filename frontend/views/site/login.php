<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ورود';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>برای وارد شدن ابتدا فیلد های زیر را وارد کنید</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('نام کاربری') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('گذرواژه') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('مرا به خاطر بسپار') ?>

                <div style="color:#999;margin:1em 0">
                    گذرواژتو فراموش کردی ؟  <?= Html::a('بازگردانی گذرواژه', ['site/request-password-reset']) ?>
                    <br>
                    فرستادن دوباره ی تایید ایمیل  <?= Html::a('ارسال دوباره', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('ورود', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
