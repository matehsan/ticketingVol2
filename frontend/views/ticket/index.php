<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ticket';
$this->params['breadcrumbs'][] = $this->title;
echo "<h1>"."Your ".$this->title."</h1>"
?>
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
        [
            'label'=>'Created at',
            'format' => 'raw',
            'value'=>function ($data) {
                return Yii::$app->jdate->date('Y/m/d H:i',$data->created_at);
            }
        ],
//        'created_at',
        //'is_answered',
        //'is_closed',
        'product_id',
        [
            'label' => 'situation',
            'format' => 'raw',
            'value' => function ($data) {
                if($data->is_closed==false) {
                    if ($data->is_answered == false) {
                        return Html::a('در انتطار', ['conversation/index', 'ticket_id' => $data->id], ['class' => 'btn btn-warning']);
                    } else {
                        return Html::a('جواب داری!', ['conversation/index', 'ticket_id' => $data->id,], ['class' => 'btn btn-success', 'data-method' => 'POST']);
                    }
                }
                else{
                    return Html::a('بسته شده', ['conversation/index','ticket_id'=>$data->id], ['class' => 'btn btn-default']);
                }
            },
        ],
    ],
]); ?>


