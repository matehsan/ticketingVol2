<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ثبت نام';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>برای ثبت نام ابتدا فیلد های زیر را پر کنید:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('نام کاربری') ?>

                <?= $form->field($model, 'email')->label('پست الکترونیکی') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('گذرواژه') ?>

                <div class="form-group">
                    <?= Html::submitButton('ثبت نام', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
