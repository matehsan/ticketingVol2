<?php

namespace backend\controllers;

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

        $new_conversation = new conversation();
        $user = User::findIdentity(Yii::$app->user->getId());
        $new_conversation->user_id = $user->id;
        $new_conversation->ticket_id = $ticket_id;

        if ($new_conversation->load(Yii::$app->request->post()) && $new_conversation->save()) {
            if (UploadedFile::getInstance($new_conversation, 'file')) {
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
            $ticket->admin_id = Yii::$app->user->id;
            $ticket->is_answered = 1;
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

    /**
     * Displays a single Conversation model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Conversation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Conversation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Conversation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Conversation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Conversation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conversation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conversation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
