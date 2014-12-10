<?php

class PaypalForm extends CFormModel {

    public $amount;

    public function rules() {
        return array(
            array('amount', 'required'),
//            array('amount', 'numerical', 'integerOnly' => true),
            array('amount', 'numerical'),
        );
    }

    public function attributeLabels() {
        return array(
            'amount' => Yii::t('credits', 'Sum'),
        );
    }

}
