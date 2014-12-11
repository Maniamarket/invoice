<?php

namespace app\modules\payments\models;

use Yii;
use yii\base\Model;

class PaypalForm extends Model {

    public $amount;
    public $currency;
    public $mode;
    public $proccessUrl;
    public $businessEmail;
    public $defaultCurrency;

    public function init() {
        $config = Yii::$app->controller->module->config;
        $mode = $config['mode'];
        $this->proccessUrl = $config['paypal'][$mode]['proccessUrl'];
        $this->businessEmail = $config['paypal'][$mode]['businessEmail'];
        $this->defaultCurrency = $config['paypal'][$mode]['defaultCurrency'];
        parent::init();
    }

    public function rules() {
        return array(
            [['amount', 'currency'], 'required'],
            [['amount'], 'double'],
            [['currency'], 'integer'],
        );
    }

    public function attributeLabels() {
        return array(
            'amount' => Yii::t('payment', 'Amount'),
        );
    }

}
