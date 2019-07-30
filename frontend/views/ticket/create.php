<?php

use common\models\Product;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'ارسال تیکت';
$this->params['breadcrumbs'][] = $this->title;


/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div>
    <?= $form->field($ticket, 'subject')->textInput(['maxlength' => true])->label('موضوع') ?>
</div>
<div>
    <?= $form->field($ticket, 'product_id')->dropDownList(
        ArrayHelper::map(product::find()->all(), 'id', 'name'),
        ['prompt' => 'انتخاب کنید...']

    )->label('نوع') ?></div>

<?= $form->field($ticket, 'message')->textarea(['maxlength' => true])->label('پیام') ?>
<?= $form->field($ticket, 'file')->fileInput()->label('فایل') ?>
<?= Html::submitButton('ارسال', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
