<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChangePasswordForm */
/* @var $form ActiveForm */

$this->title = 'Change Password';
?>
<div class="user-changePassword">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->passwordInput()->label('گذرواژه ی جدید') ?>
    <?= $form->field($model, 'confirm_password')->passwordInput()->label('تایید گذرواژه') ?>

    <div class="form-group">
        <?= Html::submitButton('ثبت', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>