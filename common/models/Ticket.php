<?php

namespace common\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $subject
 * @property string $message
 * @property int $customer_id
 * @property int $admin_id
 * @property string $created_at
 * @property int $is_answered
 * @property int $is_closed
 * @property int $product_id
 *
 * @property Conversation[] $conversations
 * @property User $customer
 * @property User $admin
 * @property Product $product
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'message', 'product_id'], 'required'],
            [['message'], 'string'],
            [['customer_id', 'admin_id', 'is_answered', 'is_closed', 'product_id'], 'integer'],
            [['created_at'], 'safe'],
            [['subject'], 'string', 'max' => 100],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['admin_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'message' => 'Message',
            'customer_id' => 'Customer ID',
            'admin_id' => 'Admin ID',
            'created_at' => 'Created At',
            'is_answered' => 'Is Answered',
            'is_closed' => 'Is Closed',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConversations()
    {
        return $this->hasMany(Conversation::className(), ['ticket_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    public function getModel($id){
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function makeClosed(){
        $this->is_closed=true;
    }

}
