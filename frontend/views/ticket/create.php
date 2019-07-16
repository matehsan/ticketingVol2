<?php

use common\models\Product;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $ticket common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>





<div class="">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4 pull-right">
            <div class="card border-primary text-center">
                <div class="card-header"><?= $form->field($ticket, 'subject')->textInput(['maxlength' => true]) ?></div>
                <div class="product">

                    <?= $form->field($ticket, 'product_id')->dropDownList(
                        ArrayHelper::map(product::find()->all(), 'id', 'name'),
                        ['prompt' => 'select product']

                    ) ?>
                </div>
                <div class="card-body ">
                    <div class="description">
                        <p class="card-text"><?= $form->field($ticket, 'message')->textarea(['maxlength' => true]) ?></p>
                    </div>
                    <div class="file">
                        <?= $form->field($ticket,'file')->fileInput()?>
                    </div>
                </div>
                <a href="#">
                    <h1 class="card-footer">

                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

                    </h1>
                </a>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>