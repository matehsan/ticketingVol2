<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "conversation".
 *
 * @property int $id
 * @property string $message
 * @property string $file
 * @property int $user_id
 * @property int $ticket_id
 * @property string $created_at
 *
 * @property Ticket $ticket
 * @property User $user
 */
class Conversation extends \yii\db\ActiveRecord
{
    public $updated_at;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conversation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message', 'user_id', 'ticket_id',], 'required'],
            [['user_id', 'ticket_id'], 'integer'],
            [['created_at','updated_at'], 'safe'],
            [['file'], 'string', 'max' => 300],
            [['message'], 'string', 'max' => 1000],
            [['file'],'file','extensions'=>'png,jpg,pdf,docx'],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::className(), 'targetAttribute' => ['ticket_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'user_id' => 'User ID',
            'ticket_id' => 'Ticket ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::className(), ['id' => 'ticket_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /*qable save shodan to db user_id ro set mikone */

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            $this->user_id = Yii::$app->user->getId();
            return true;
        }

    }
    public function afterFind()
    {
        $this->created_at=Yii::$app->jdate->date('Y/m/d H:i',$this->created_at);
        parent::afterFind();
    }

    public function behaviors()
    {
        return[
          TimestampBehavior::className(),
        ];
    }

}
