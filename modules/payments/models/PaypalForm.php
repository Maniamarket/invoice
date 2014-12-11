<?php

namespace app\modules\payments\models;

use Yii;
use yii\base\Model;

class PaypalForm extends Model {

    public $amount;

    CONST LIFE_PAYPAL_URL = 'https://www.paypal.com/cgi-bin/webscr';
    CONST TEST_PAYPAL_URL = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    CONST TEST_BUSINES_PAYPAL_EMAIl = 'arsen.sitdikov@gmail.com';
    CONST LIFE_BUSINES_PAYPAL_EMAIl = 'arsen.sitdikov@gmail.com';

    public function rules() {
        return array(
            array('amount', 'required'),
                //array('amount', 'numerical'),
        );
    }

    public function attributeLabels() {
        return array(
            'amount' => Yii::t('lang', 'Amount'),
        );
    }

}
