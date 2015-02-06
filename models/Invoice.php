<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;


class Invoice extends ActiveRecord
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
            [[ 'client_id', 'company_id' ], 'required'],
            [['user_id',  'client_id', 'vat_id','company_id'], 'integer','min'=>1],
            ['type', 'default', 'value' => 'basic'],
            ['type', 'string', 'max' => 50],
            [['total_price', 'net_price', 'income'], 'integer', 'integerOnly'=>FALSE],
            [['date'], 'safe'],
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

    public static function queryProvider($qp) {
        $query = self::find()->where(
            ['user_id'=>  Yii::$app->user->id]
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
    
    public static function getPriceTax(Invoice $model)
    {
        $price = $model->price_service*$model->count;
        
        return ['vat'=>$price*$model->vat/100, 'tax'=>$price*$model->tax/100];
    }


}
