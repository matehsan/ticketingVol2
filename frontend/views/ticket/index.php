<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<!--<div class="ticket-index">-->
<!---->
<!--    <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--    <p>-->
<!--        --><?//= Html::a('Create Ticket', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->
<!---->
<!--    --><?php //// echo $this->render('_search', ['model' => $searchModel]); ?>
<!---->
<!--    --><?//= GridView::widget([
//        'dataProvider' => $dataProvider,
////        'filterModel' => $searchModel,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'subject',
//            'message:ntext',
//            'customer_id',
//            'admin_id',
//            //'created_at',
//            //'is_answered',
//            //'is_closed',
//            //'product_id',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]); ?>
<!--</div>-->


<?=''/*  ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'ticketTemplate',
]);*/?>
<!---->
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

//        'id',
        'subject',
        'message:ntext',
//        'customer_id',
//        'admin_id',
        //'created_at',
        //'is_answered',
        //'is_closed',
        'product_id',
        [
            'label' => 'situation',
            'format' => 'raw',
            'value' => function ($data) {
                if($data->is_closed==false) {
                    if ($data->is_answered == false) {
                        return Html::a('در انتطار', ['conversation/index', 'id' => $data->id], ['class' => 'btn btn-warning']);
                    } else {
                        return Html::a('جواب داری!', ['conversation/index', 'id' => $data->id,], ['class' => 'btn btn-success', 'data-method' => 'POST']);
                    }
                }
                else{
                    return Html::a('بسته شده', ['conversation/index','id'=>$data->id], ['class' => 'btn btn-default']);
                }
            },
        ],
    ],
]); ?>


