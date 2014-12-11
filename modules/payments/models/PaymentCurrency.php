<?php

namespace app\modules\payments\models;

use Yii;

/**
 * This is the model class for table "payment_currency".
 *
 * @property integer $id
 * @property integer $operator_id
 * @property string $char_code
 * @property string $name
 * @property double $curs
 * @property integer $active
 * @property string $last_modify
 *
 * @property User $operator
 * @property PaymentHistory[] $paymentHistories
 */
class PaymentCurrency extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'payment_currency';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['operator_id', 'active'], 'integer'],
            [['char_code', 'name', 'curs'], 'required'],
            [['curs'], 'number'],
            [['last_modify'], 'safe'],
            [['char_code'], 'string', 'max' => 3],
            [['name'], 'string', 'max' => 128],
            [['char_code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('payment', 'ID'),
            'operator_id' => Yii::t('payment', 'Operator ID'),
            'char_code' => Yii::t('payment', 'Char Code'),
            'name' => Yii::t('payment', 'Name'),
            'curs' => Yii::t('payment', 'Curs'),
            'active' => Yii::t('payment', 'Active'),
            'last_modify' => Yii::t('payment', 'Last Modify'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActiveCurrency() {
        return $this->find()->asArray()->where('active = :active', ['active' => true])->all();
    }

    public function getEquivalent($amount, $curs, $margin = 0) {
        return ($amount + ($amount * $margin)) * $curs;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyById($id) {
        $currency = $this->find()->where('id=:id AND active = :active', ['id' => $id, 'active' => true])->one();

        if (empty($currency)) {
            throw new \yii\web\HttpException(400, Yii::t('payment', 'Wrong curremsy'), 405);
        }
        return $currency;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator() {
        return $this->hasOne(User::className(), ['id' => 'operator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentHistories() {
        return $this->hasMany(PaymentHistory::className(), ['currency_id' => 'id']);
    }

}
