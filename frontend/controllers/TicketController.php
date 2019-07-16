<?php

namespace frontend\controllers;

use common\models\Conversation;
use common\models\User;
use Yii;
use common\models\Ticket;
use common\models\TicketSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ContentDecorator;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
            $query = Ticket::find()->where('customer_id='. Yii::$app->user->getId());
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 6,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'is_closed'=>SORT_ASC,
                        'is_answered' => SORT_DESC,
                        'created_at' => SORT_DESC,

                    ]
                ],
            ]);
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Displays a single Ticket model.
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
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
            $ticket = new Ticket();
            if ($ticket->load(Yii::$app->request->post())) {
                $ticket->customer_id = Yii::$app->user->getId();
                $file=UploadedFile::getInstance($ticket,'file');
                $file->saveAs('uploads/ticket'.$ticket->id.'.'.$file->extension);
                $ticket->file='uploads/ticket'.$ticket->id.'.'.$file->extension;
                $ticket->save();

//                @todo ye answer besaze
                $conversation = new Conversation();
                $conversation->message=$ticket->message;
                $conversation->ticket_id=$ticket->id;
                $conversation->user_id=Yii::$app->user->getId();
                $conversation->save();

                return $this->redirect(['conversation/index', 'ticket_id' => $ticket->id,]);
//                return $this->redirect(['ticket/index']);
            }
            return $this->render('create', [
                'ticket' => $ticket,
            ]);
    }
    public function actionClose($ticket_id)
    {
        $ticket = Ticket::findOne($ticket_id);
        $ticket->is_closed = 1;
        if(!$ticket->save()) {
            var_dump($ticket->errors);
            exit();
        }
        $this->redirect('index');
    }
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
