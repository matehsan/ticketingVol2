<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'تیکت ها';
$this->params['breadcrumbs'][] = $this->title;
echo "<h1>تیکت های شما</h1>"
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

//        'id',
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
//        'customer_id',
//        'admin_id',
        [
            'label'=>'زمان ایجاد',
            'format' => 'raw',
            'value'=>function ($data) {
                return Yii::$app->jdate->date('Y/m/d H:i',$data->created_at);
            }
        ],
//        'created_at',
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
            'label' => 'وضعیت',
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



