<?php

namespace frontend\controllers;

use common\models\Ticket;
use common\models\User;
use Yii;
use common\models\Conversation;
use common\models\ConversationSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ConversationController implements the CRUD actions for Conversation model.
 */
class ConversationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Conversation models.
     * @return mixed
     */
    public function actionIndex($ticket_id)
    {
        $ticket = Ticket::findOne($ticket_id);
        if ($ticket) {
            if ($ticket->customer_id == Yii::$app->user->getId()) {

                $new_conversation = new conversation();
                $user = User::findIdentity(Yii::$app->user->getId());
                $new_conversation->user_id = $user->id;
//        @todo unix time va behavior to modele answer baraye time create_at va updated_at
                $new_conversation->ticket_id = $ticket_id;
//                $new_conversation->message = Yii::$app->request->post('message', ' ');

                /**
                 * @todo bhjhjhjhj
                 */
                if ($new_conversation->load(Yii::$app->request->post()) && $new_conversation->save()) {

                    $file=UploadedFile::getInstance($new_conversation,'file');
                    $file->saveAs('../../common/uploads/ticket/'.$ticket_id.'/'.$new_conversation->id.'_conversation.'.$file->extension);
                    $new_conversation->file='../../common/uploads/ticket/'.$ticket_id.'/'.$new_conversation->id.'_conversation.'.$file->extension;
                    $new_conversation->save();

                    $ticket->is_answered = false;
                    $ticket->save();
                    return $this->redirect(['index', 'ticket_id' => $ticket_id]);
                }
                $query = conversation::find()->where('ticket_id=' . $ticket_id);
                $conversations = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 20
                    ],
                    'sort' => [
                        'defaultOrder' => [
                            'created_at' => SORT_ASC,
                        ]
                    ],
                ]);
                return $this->render('index', [
                    'conversations' => $conversations->getModels(),
                    'new_conversation' => $new_conversation,
                ]);
            }
            else{
                return $this->redirect('../ticket/index');
            }
        }
        else{
            return $this->redirect('../ticket/index');
        }
    }
}
