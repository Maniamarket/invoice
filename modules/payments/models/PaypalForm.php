<?php
namespace app\modules\payments\models;

use Yii;
use yii\base\Model;

class PaypalForm extends Model {

    public $amount;

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
