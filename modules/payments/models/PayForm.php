<?php
namespace app\modules\payments\models;

use Yii;
use yii\base\Model;

class PayForm extends Model {

    const MINIMUM = 25;

    public $payment_system_id;
    public $amount;

    public function rules() {
        return array(
            array('amount', 'required', 'message' => Yii::t('mypurse', 'You must specify the amount of recharge')),
            array('amount', 'numerical', 'min' => self::MINIMUM, 'message' => Yii::t('mypurse', 'Amount must be a number'), 'tooSmall' => Yii::t('mypurse', 'Amount too small. Minimum ${amount}', array('{amount}' => self::MINIMUM))),
            array('payment_system_id', 'paymentSystem'),
        );
    }

    public function attributeLabels() {
        return array(
            'amount' => Yii::t('app', 'Amount').', $',
            'payment_system_id' => Yii::t('mypurse', 'Top-up through'),
        );
    }

    public function paymentSystem($attribute, $params) {
        $model = PaymentSystem::model()->findByPk($this->payment_system_id);
        if (!$model) {
            $this->addError($attribute, Yii::t('mypurse', 'You must select a payment type'));
        }
    }

}
