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
            [[ 'client_id', 'name', 'company_id', 'service_id', 'vat', 'tax', 'discount'], 'required'],
//            [['user_id', 'date', 'seller_id', 'sender_addr', 'recipient_addr', 'client_id', 'currency_id'], 'required'],
//            [['user_id', 'seller_id', 'client_id', 'currency_id'], 'integer'],
            [['user_id',  'client_id',  'count'], 'integer'],
            [['vat',  'tax',  'discount'], 'integer', 'integerOnly'=>FALSE],
            [['date','company_id', 'service_id'], 'safe'],
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
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'count' => Yii::t('app', 'count'),
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

    public function getClient()
    {
        return $this->hasOne('app\models\Client', array('id' => 'client_id'));
    }

    public function getUser()
    {
        return $this->hasOne('app\models\User', array('id' => 'user_id'));
    }

    public function getCompany()
    {
        return $this->hasOne('app\models\Company', array('id' => 'company_id'));
    }

    public function getService()
    {
        return $this->hasOne('app\models\Service', array('id' => 'service_id'));
    }

    public static function queryProvider($qp) {
        $query = self::find()->where(
            [/*'user_id'=>  Yii::$app->user->id*/]
        );
        if (isset($qp['name']))
        {
            if ( !empty($qp['name']))
                $query->andFilterWhere(['like', 'name', $qp['name']]);
            if (isset($qp['orderby'])) {
                $orderBy = ($qp['orderby']=='asc')? SORT_ASC:SORT_DESC;
                $query->orderBy(['name'=>$orderBy]);
            }

        }
        return $query;
    }
    
    public function getPriceTax(Invoice $model)
    {
        $tax = $model->vat + $model->surtax;
        $price = $model->price_service*$model->count;
        var_dump($price);
        return $price;
    }


}
