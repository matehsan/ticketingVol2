<?php

use common\models\Conversation;
use common\models\ConversationSearch;
use common\models\Ticket;
use common\models\User;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $searchModel common\models\ConversationSearch */
/* @var $conversations yii\data\ActiveDataProvider */
/* @var $new_conversation common\models\Conversation */
/* @var $model common\models\conversation */
$this->title = 'conversations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <p>
        <?php
        $ticket = Ticket::findOne(Yii::$app->request->get('ticket_id'));
        if ($ticket->is_closed == true) {
            $this->title = 'conversations is closed';
        } else {
            $this->title = 'conversations';
        }
        ?>
    </p>
    <style>
        .userMessage {
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

        .pn {
            text-align: right;
            color: grey;
        }


    </style>
    <?php foreach ($conversations as $conversation) { ?>
        <div class="<?php if (User::findByUsername($conversation->user->username)->role == "customer") {
            echo 'userMessage';
        } else {
            echo 'admin';
        } ?>">
            <div> <?= $conversation->message ?> </div>

            <?php if ($conversation->file) {

                $pos=strrpos($conversation->file,'.') ;
                $extension=substr($conversation->file,strrpos($conversation->file,'.'));
                ?>
                <?php
                if($extension=='.png' || $extension=='.jpg'){ ?>
                    <div><a href="<?php echo $conversation->file ?>"><img src="<?php echo $conversation->file ?>" width="45%"></a></div><?php }
                else{ ?>
                    <div><a href="<?php echo $conversation->file ?>" download><div style="background-attachment: local">download attachFile</div></a></div> <?php } ?>
            <?php } ?>
            <div class="pn"><code><?= $conversation->user->username." [ ".$conversation->created_at." ]"." ".'<i class="fas fa-file-image"></i>'?></code></div>
        </div>


    <?php } ?>


</div>
<div class="answer-create">


    <?php
    if (!$ticket->is_closed == true){
    $form = ActiveForm::begin();
    ?>

    <h3><?= $form->field($new_conversation, 'message')->textarea(['maxlength' => true, 'value' => Yii::$app->request->get('message'),]) ?></h3>
    <h6><?= $form->field($new_conversation, 'file')->fileInput() ?></h6>
</div>
<?php
echo Html::submitButton('ارسال پیام', ['class' => 'btn btn-success'])." ";
echo Html::a('بستن تیکت', ['ticket/close', 'ticket_id' => Yii::$app->request->get('ticket_id')], ['class' => 'btn btn-danger'])

?>


<?php ActiveForm::end(); ?><?php } ?>

</div>
