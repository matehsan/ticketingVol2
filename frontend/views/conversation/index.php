<?php

use common\models\Ticket;
use common\models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel common\models\ConversationSearch */
/* @var $conversations yii\data\ActiveDataProvider */
/* @var $new_conversation common\models\Conversation */
/* @var $model common\models\conversation */
$this->title = 'conversations';
$this->params['breadcrumbs'][] = $this->title;
?>

<!---->
<?php //foreach ($conversations as $conversation){ ?>
<!---->
<!--<div class="card text-center">-->
<!--    <div class="owner-message ">-->
<!--        --><?php //echo $conversation->owner ?><!--:-->
<!--    </div>-->
<!--    <div class="message">-->
<!--        --><?php //echo $conversation->message ?>
<!--    </div>-->
<!--    <div class="created-at">-->
<!--        created at:--><?php //echo $conversation->created_at ?>
<!--    </div>-->
<!--    <div>-->
<!---->
<!--        --><?php //} ?>
<!--        --><?php
//        $ticket=Ticket::findOne(Yii::$app->request->get('id'));
//        if(!$ticket->isClosed==true){
//        $form =ActiveForm::begin();
//        ?>
<!--        <div class="card text-center">-->
<!--            <div class="card-header">-->
<!---->
<!--                <h1>--><?//= $form->field($newconversation, 'message')->textarea(['maxlength' => true, 'value' => Yii::$app->request->get('message'),]) ?><!--</h1>-->
<!--            </div>-->
<!--            <div class="card-footer bg-success">-->
<!--                --><?php
//                echo Html::submitButton('ارسال پیام', ['class' => 'btn btn-success']);
//                echo  Html::a('بستن تیکت',['ticket/close','IdTicket'=>Yii::$app->request->get('id')],['class'=>'btn btn-danger'])
//
//                ?>
<!---->
<!--            </div>-->
<!--        </div>-->
<?php //ActiveForm::end() ; ?><!----><?php //} ?>

<div class="answer-index">

    <p>
        <?php
        $ticket=Ticket::findOne(Yii::$app->request->get('id'));
        if($ticket->is_closed==true){
            $this->title = 'conversations is closed';
        }
        else{
            $this->title = 'conversations';
        }
        ?>
    </p>
    <style>
        .userMessage{
            border-radius: 5px;
            background-color: #86BB71;
            margin-bottom: 3px;
            padding: 10px;
            text-align: left;
        }
        .admin {
            border-radius: 5px;
            background-color: #94C2ED;
            margin-bottom: 3px;
            padding: 10px;
            text-align: left;
        }
        .pn{
            text-align: right;
            color: grey;
        }

    </style>
    <?php foreach ($conversations as $conversation){ ?>
        <div class="<?php if (User::findByUsername($conversation->user->username)->role == "customer"){echo 'userMessage';}else{echo 'admin';} ?>">
            <?= $conversation->message ?>
            <div class="pn"><code><?= $conversation->user->username." [ ".$conversation->created_at." ]"?></code></div>
        </div>




    <?php } ?>


</div>
<div class="answer-create">


    <?php
    if(!$ticket->is_closed==true){
        $form =ActiveForm::begin();
        ?>
        <div class="card text-center">
            <div class="card-header">

                <h1><?= $form->field($new_conversation, 'message')->textarea(['maxlength' => true, 'value' => Yii::$app->request->get('message'),]) ?></h1>
            </div>
            <div class="card-footer bg-success">
                <?php
                echo Html::submitButton('ارسال پیام', ['class' => 'btn btn-success']);
                echo  Html::a('بستن تیکت',['ticket/close','ticket_id'=>Yii::$app->request->get('id')],['class'=>'btn btn-danger'])

                ?>

            </div>
        </div>
        <?php ActiveForm::end() ; ?><?php } ?>

</div>
