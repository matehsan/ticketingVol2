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
                $new_conversation->ticket_id = $ticket_id;

                if ($new_conversation->load(Yii::$app->request->post()) && $new_conversation->save()) {
                    if(UploadedFile::getInstance($new_conversation, 'file')) {
                        $file = UploadedFile::getInstance($new_conversation, 'file');

                        $dir='uploads/ticket/' . $ticket_id . '/' ;
                        if(is_dir($dir) && file_exists($dir)) {

                            $file->saveAs('uploads/ticket/' . $ticket_id . '/' . $new_conversation->id . '_conversation.' . $file->extension);
                        }
                        else{
                            mkdir('uploads/ticket/' . $ticket->id . '', 0777, true);
                            $file->saveAs('uploads/ticket/' . $ticket_id . '/' . $new_conversation->id . '_conversation.' . $file->extension);
                        }

                        $new_conversation->file = 'uploads/ticket/' . $ticket_id . '/' . $new_conversation->id . '_conversation.' . $file->extension;
                        $new_conversation->save();
                    }

                    $ticket->is_answered = 0;
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
