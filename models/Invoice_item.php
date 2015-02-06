<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

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
class Invoice_item extends ActiveRecord
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
            [['invoice_id','service_id','count'], 'number','integerOnly' => true,'min' => '0'],
            [['invoice_id','service_id','price_service','count','discount'], 'required'],
            [['price_service','total_price','discount'], 'integer','integerOnly' => false,'min' => '0'],
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
