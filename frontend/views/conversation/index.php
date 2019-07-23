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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

<div class="answer-index">

    <p>
        <?php
        $ticket=Ticket::findOne(Yii::$app->request->get('ticket_id'));
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
            word-wrap: break-word;
            border-radius: 5px;
            background-color: #86BB71;
            margin-bottom: 3px;
            padding: 10px;
            text-align: left;
        }
        .admin {
            word-wrap: break-word;
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

    <?php //todo aqa in akso bayad dors konim
    foreach ($conversations as $conversation){ ?>
        <div class="<?php if (User::findByUsername($conversation->user->username)->role == "customer"){echo 'userMessage';}else{echo 'admin';} ?>">
            <?= $conversation->message ?>
            <img src="<?php
            if ($conversation->file) {
                echo $conversation->file ;
            }?>">
            <div class="pn"><code><?= $conversation->user->username." [ ".$conversation->created_at." ]"." ".'<i class="fas fa-file-image"></i>'?></code></div>
        </div>




    <?php } ?>


</div>
<div class="answer-create">


    <?php
    if(!$ticket->is_closed==true){
        $form =ActiveForm::begin();
        ?>

                <h3><?= $form->field($new_conversation, 'message')->textarea(['maxlength' => true, 'value' => Yii::$app->request->get('message'),]) ?></h3>
                <h6><?= $form->field($new_conversation, 'file')->fileInput()?></h6>
                <?php
                echo Html::submitButton('ارسال پیام', ['class' => 'btn btn-success'])." ";
                echo  Html::a('بستن تیکت',['ticket/close','ticket_id'=>Yii::$app->request->get('ticket_id')],['class'=>'btn btn-danger'])

                ?>

        </div>
        <?php ActiveForm::end() ; ?><?php } ?>

</div>
