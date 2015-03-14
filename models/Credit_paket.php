<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class Credit_paket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'credit_paket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'price'], 'required'],
            [['value'], 'integer'],
            [['price'], 'integer','integerOnly' => false],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'value' => Yii::t('app', 'Quantity credits'),
            'price' => Yii::t('app', 'Cost'),
        ];
    }

    public static function listPaket()
    {
        $paket = Credit_paket::find()->select('value,price')->all();
        return ArrayHelper::map($paket,'value', 'price');
    }
}
