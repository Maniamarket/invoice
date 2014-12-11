<?php

namespace app\modules\payments\models;

use Yii;

/**
 * This is the model class for table "tbl_payment_history".
 *
 * The followings are the available columns in table 'tbl_payment_history':
 * @property string $id
 * @property string $user_id
 * @property string $operator_id
 * @property double $amount
 * @property string $currency
 * @property double $curs
 * @property double $equivalent
 * @property string $description
 * @property string $date
 * @property string $payment_system_id
 * @property integer $complete
 * @property integer $type
 * The followings are the available model relations:
 * @property paymentSystem $paymentSystem
 * @property user $user
 * @property user $operator
 * @property paymentOutput $paymentOutput
 */
class PaymentHistory extends \yii\db\ActiveRecord {

    const PT_MANUAL = 10;
    const PT_MONEY_TRANSFER = 20;
    const PT_PAYPAL = 30;

    public function init() {
        $this->type = self::PT_MANUAL;
        $this->complete = 0;
        parent::init();
    }

    public static function tableName() {
        return 'payment_history';
    }

    public function rules() {
        return [
            [['user_id', 'operator_id', 'currency_id', 'payment_system_id', 'complete', 'type'], 'integer'],
            [['amount', 'currency_id', 'payment_system_id'], 'required'],
            [['amount', 'curs', 'equivalent'], 'number'],
            [['date'], 'safe'],
            [['description'], 'string', 'max' => 128]
        ];
    }

    public function relations() {
        return array(
            'paymentSystem' => array(self::BELONGS_TO, 'PaymentSystem', 'payment_system_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'operator' => array(self::BELONGS_TO, 'User', 'operator_id'),
            'currency' => array(self::HAS_ONE, 'PaymentCurrency', 'currency_id'),
        );
    }
    
    public function getNonCompleteById($id) {
        return $this->find()->where('id=:id AND complete = :complete', ['id' => $id, 'complete' => false])->one();
    }

    public function attributeLabels() {
        return [
            'id' => Yii::t('payment', 'ID'),
            'user_id' => Yii::t('payment', 'User ID'),
            'operator_id' => Yii::t('payment', 'Operator ID'),
            'amount' => Yii::t('payment', 'Amount'),
            'currency_id' => Yii::t('payment', 'Currency ID'),
            'curs' => Yii::t('payment', 'Curs'),
            'equivalent' => Yii::t('payment', 'Equivalent'),
            'description' => Yii::t('payment', 'Description'),
            'date' => Yii::t('payment', 'Date'),
            'payment_system_id' => Yii::t('payment', 'Payment System ID'),
            'complete' => Yii::t('payment', 'Complete'),
            'type' => Yii::t('payment', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentSystem() {
        return $this->hasOne(PaymentSystem::className(), ['id' => 'payment_system_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
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
    public function getCurrency() {
        return $this->hasOne(PaymentCurrency::className(), ['id' => 'currency_id']);
    }

    public function getDate($format = 'd M Y') {
        return date($format, strtotime($this->date));
    }

    public function getStatus() {
        return ($this->complete) ? Yii::t('payment', 'Complete') : Yii::t('payment', 'Not Complete');
    }

    public function getCssClass() {
        return ($this->complete) ? 'complete' : 'complete fail';
    }

    public function getType() {
        switch ($this->type) {
            case self::PT_MANUAL:
                return Yii::t('payment', 'manual');
                break;
            case self::PT_MONEY_TRANSFER:
                return Yii::t('payment', 'transfer');
                break;
            case self::PT_PAYPAL:
                return Yii::t('payment', 'paypal');
                break;
        }
    }

    public function afterSave($insert, $changedAttributes) {
        //send email about payment
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete() {
        return parent::beforeDelete();
    }

    public static function balanceToDay($uid, $date) {
        return Yii::$app->db->createCommand()
                        ->select('ROUND(SUM(`amount`),2) AS `amount`')
                        ->from('payment_history')
                        ->where('user_id = :uid AND complete = 1 AND DATE(`date`) <= :date', array(':uid' => $uid, ':date' => $date))
                        ->queryScalar();
    }

}
