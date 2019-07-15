<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Conversation */

$this->title = 'Update Conversation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conversations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conversation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
