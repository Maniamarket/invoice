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
class Invoice_item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        //    [[ 'client_id', 'date', 'company_id', 'service_id', 'price_service', 'vat', 'tax', 'discount'], 'required'],
            [['user_id',  'client_id'], 'integer'],
            ['type', 'default', 'value' => 'basic'],
            ['type', 'string', 'max' => 50],
            [['total_price', 'net_price'], 'integer', 'integerOnly'=>FALSE],
            [['date','company_id','surtax'], 'safe'],
         //   [['number', 'bill_number'], 'string', 'max' => 32],
       //     [['sender_addr', 'recipient_addr'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function getService()
    {
        return $this->hasOne('app\models\Service', array('id' => 'service_id'));
    }

}
