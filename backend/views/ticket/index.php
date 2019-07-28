<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Ticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',
            'message:ntext',
            'customer_id',
            'admin_id',
            [
                'label'=>'Created at',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Yii::$app->jdate->date('Y/m/d H:i',$data->created_at);
                }
            ],
//            'created_at',
            //'is_answered',
            //'is_closed',
            //'product_id',
            [
                'label'=>'Situation',
                'format' => 'raw',
                'value'=>function ($data) {
                    if ($data->is_closed == false) {
                        if ($data->is_answered == 0) {
                            return Html::a('Answer', ['/conversation/index', 'ticket_id' => $data->id], ['class' => 'btn btn-danger', 'data-method' => 'POST']);

                        } else {
                            return Html::a('Answer', ['/conversation/index', 'ticket_id' => $data->id], ['class' => 'btn btn-success', 'data-method' => 'POST']);
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
