<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property integer $invoice_id
 * @property string $name
 * @property integer $measure_id
 * @property integer $amount
 * @property string $price
 * @property string $excise
 * @property integer $tax
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invoice_id', 'name', 'measure_id', 'amount', 'price'], 'required'],
            [['invoice_id', 'measure_id', 'amount', 'tax'], 'integer'],
            [['price', 'excise'], 'number'],
            [['name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'name' => Yii::t('app', 'Name'),
            'measure_id' => Yii::t('app', 'Measure ID'),
            'amount' => Yii::t('app', 'Amount'),
            'price' => Yii::t('app', 'Price'),
            'excise' => Yii::t('app', 'Excise'),
            'tax' => Yii::t('app', 'Tax'),
        ];
    }
}
