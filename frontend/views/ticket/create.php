<?php

use common\models\Product;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div>
    <?= $form->field($ticket, 'subject')->textInput(['maxlength' => true]) ?>
</div>
<div>
    <?= $form->field($ticket, 'product_id')->dropDownList(
        ArrayHelper::map(product::find()->all(), 'id', 'name'),
        ['prompt' => 'Select product']

    ) ?></div>

<?= $form->field($ticket, 'message')->textarea(['maxlength' => true]) ?>
<?= $form->field($ticket, 'file')->fileInput() ?>
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>
