<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تیکت ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'subject',
            //'message:ntext',
            [
                'label'=>'پیام ها',
                'format' => 'raw',
                'value'=>function ($data) {
                    if (strlen($data->message) > 150){

                        $maxLength = 149;
                        $yourString = substr($data->message, 0, $maxLength);

                        return $yourString.'...';
                    }else{
                        return $data->message;
                    };
                }
            ],
            //'customer_id',
            [
                'label'=>'متقاضی',
                'format' => 'raw',
                'value'=>function ($data) {
                    return User::findIdentity($data->customer_id)->username;
                }
            ],
            //'admin_id',
            [
                'label'=>'پاسخ دهنده',
                'format' => 'raw',
                'value'=>function ($data) {
                    if (!$data->admin_id == null) {
                        $esm = \common\models\User::findIdentity($data->admin_id)->username;
                        if (Yii::$app->user->identity->username == $esm) {
                            return "شما";
                        } else {
                            return $esm;
                        }
                    }else{
                        return "هیچکس";
                    }
                }
            ],
            [
                'label'=>'زمان ایجاد',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Yii::$app->jdate->date('Y/m/d H:i',$data->created_at);
                }
            ],
            //'created_at',
            //'is_answered',
            //'is_closed',
            //'product_id',
            [
                'label'=>'محصول',
                'format' => 'raw',
                'value'=>function ($data) {
                    if ($data->product_id == null){
                        return "سایر";
                    }else{
                        return $data->product->name ;
                    }
                }
            ],
            [
                'label'=>'وضیعت',
                'format' => 'raw',
                'value'=>function ($data) {
                    if ($data->is_closed == false) {
                        if ($data->is_answered == 0) {
                            return Html::a('جواب بده', ['/conversation/index', 'ticket_id' => $data->id], ['class' => 'btn btn-danger', 'data-method' => 'POST']);

                        } else {
                            return Html::a('نوبت اونه', ['/conversation/index', 'ticket_id' => $data->id], ['class' => 'btn btn-success', 'data-method' => 'POST']);
                        }
                    }
                    else{
                        return Html::a('بسته شده', ['/conversation/index','ticket_id'=>$data->id], ['class' => 'btn btn-default']);
                    }
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
