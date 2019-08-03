<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'پنل کاربری';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'role',
            //'username',
            [
                'label'=>'نام کاربری',
                'format' => 'raw',
                'value'=>function ($data) {
                    return $data->username;
                }
            ],
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            //'email:email',
            [
                'label'=>'پست الکترونیکی',
                'format' => 'raw',
                'value'=>function ($data) {
                    return $data->email;
                }
            ],
//            'status',
            //'created_at',
            [
                'label'=>'زمان ایجاد',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Yii::$app->jdate->date('Y/m/d H:i',$data->created_at);
                }
            ],
            //'updated_at',
            [
                'label'=>'آخرین تغییر',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Yii::$app->jdate->date('Y/m/d H:i',$data->updated_at);
                }
            ],
//            'verification_token',
        ],
    ]) ?>

</div>
<p>
    <?= Html::a('بازنگری گذرواژه', ['change-password'], ['class' => 'btn btn-primary']) ?>
</p>