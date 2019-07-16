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
    public function actionIndex($id)
    {
        $ticket=Ticket::findOne($id);
        //@todo check user

        $new_conversation = new conversation();
        $user=User::findIdentity(Yii::$app->user->getId());

//        $new_conversation->owner=$user->getUsername();
//        $new_conversation->owner=Yii::$app->user->identity->username;
        $new_conversation->user_id=$user->id;
//        @todo unix time va behavior to modele answer baraye time create_at va updated_at
        date_default_timezone_set('Asia/tehran');
        $new_conversation->created_at = date('Y-m-d H:i:s');
        $new_conversation->ticket_id=$id;
        $new_conversation->message=Yii::$app->request->post('message',' ');

        /**
         * @todo bhjhjhjhj
         */
        if ($new_conversation->load(Yii::$app->request->post()) && $new_conversation->save()) {

//            $ticket = new Ticket();
//            $ticket = $ticket->getModel($new_conversation->IdTicket);
            $ticket->is_answered = false;
            $ticket->save();
            return $this->redirect(['index', 'id'=>$ticket->id]);
        }
        $query=conversation::find()->where('ticket_id='.$id);
        $conversations=new ActiveDataProvider([
            'query'=>$query,
            'pagination'=>[
                'pageSize'=>20
            ],
            'sort'=>[
                'defaultOrder'=>[
                    'created_at'=>SORT_ASC,
                ]
            ],
        ]);
        return $this->render('index', [
            'conversations' => $conversations->getModels(),
            'new_conversation'=>$new_conversation,
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
