<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $number
 * @property string $date
 * @property integer $seller_id
 * @property string $sender_addr
 * @property string $recipient_addr
 * @property string $bill_number
 * @property integer $client_id
 * @property integer $currency_id
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'date', 'seller_id', 'sender_addr', 'recipient_addr', 'client_id', 'currency_id'], 'required'],
            [['user_id', 'seller_id', 'client_id', 'currency_id'], 'integer'],
            [['date'], 'safe'],
            [['number', 'bill_number'], 'string', 'max' => 32],
            [['sender_addr', 'recipient_addr'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'number' => Yii::t('app', 'Number'),
            'date' => Yii::t('app', 'Date'),
            'seller_id' => Yii::t('app', 'Seller ID'),
            'sender_addr' => Yii::t('app', 'Sender Addr'),
            'recipient_addr' => Yii::t('app', 'Recipient Addr'),
            'bill_number' => Yii::t('app', 'Bill Number'),
            'client_id' => Yii::t('app', 'Client ID'),
            'currency_id' => Yii::t('app', 'Currency ID'),
        ];
    }
}
