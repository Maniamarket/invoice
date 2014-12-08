<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $date
 * @property string $name
 * @property integer $company_id
 * @property integer $service_id
 * @property integer $count
 * @property integer $vat_id
 * @property integer $discount
 * @property integer $price
 * @property integer $pay
 * @property string $type
 * @property integer $finished
 * @property string $created_date
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
            [['id', 'user_id', 'date', 'name', 'count', 'vat_id', 'discount', 'price', 'pay', 'created_date'], 'required'],
            [['user_id', 'company_id', 'service_id', 'count', 'vat_id', 'discount', 'price', 'pay', 'finished'], 'integer'],
            [['date', 'created_date'], 'safe'],
            [['id'], 'string', 'max' => 15],
            [['name'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 50]
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
            'date' => Yii::t('app', 'Date'),
            'name' => Yii::t('app', 'Name'),
            'company_id' => Yii::t('app', 'Company ID'),
            'service_id' => Yii::t('app', 'Service ID'),
            'count' => Yii::t('app', 'Count'),
            'vat_id' => Yii::t('app', 'Vat ID'),
            'discount' => Yii::t('app', 'Discount'),
            'price' => Yii::t('app', 'Price'),
            'pay' => Yii::t('app', 'Pay'),
            'type' => Yii::t('app', 'Type'),
            'finished' => Yii::t('app', 'Finished'),
            'created_date' => Yii::t('app', 'Created Date'),
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
}
