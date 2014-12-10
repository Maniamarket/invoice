<?php

class TrasferForm extends CFormModel {

    const MINIMUM = 0.1;

    public $amount;
    public $balance;
    public $email;
    public $info;
    public $accept;

    public function init() {
        $this->balance = Yii::app()->user->getModel()->balance;
        parent::init();
    }

    public function rules() {
        return array(
            array('amount', 'required', 'message' => Yii::t('mypurse', 'You must specify the amount of transfer')),
            array('email', 'required', 'message' => Yii::t('mypurse', 'You must specify the recipient\'s E-Mail')),
            array('email', 'email'),
            array('info', 'length', 'max' => 300),
            array('amount', 'numerical', 'min' => self::MINIMUM, 'message' => Yii::t('mypurse', 'Amount must be a number'), 'tooSmall' => Yii::t('mypurse', 'Amount too small. Minimum ${amount}', array('{amount}' => self::MINIMUM))),
            array('amount', 'amountCheker'),
            array('email', 'emailCheker'),
            array('accept', 'compare', 'compareValue' => 1, 'message' => Yii::t('mypurse','You must confirm the transfer of money')),
        );
    }

    public function attributeLabels() {
        return array(
            'amount' => Yii::t('mypurse', 'Amount'). ', $',
            'email' => Yii::t('mypurse', 'Email recipient'),
            'info' => Yii::t('mypurse', 'Additional Information'),
            'accept' => Yii::t('mypurse', 'The terms of the transfer is familiar. The data entered is correct. Money transfer confirm.'),
        );
    }

    public function amountCheker($attribute, $params) {
        if ($this->amount > $this->balance) {
            $this->addError($attribute, Yii::t('mypurse', 'Transfer amount can not exceed the amount of your balance'));
        }
    }
    
    public function emailCheker($attribute, $params) {
        $recipient = User::model()->findByAttributes(array('email'=> $this->email));
        if (!$recipient) {
            $this->addError($attribute, Yii::t('mypurse', 'Recipient not found'));
        }
        if ($this->email == Yii::app()->user->getModel()->email) {
            $this->addError($attribute, Yii::t('mypurse', 'Attention! Are you trying to transfer funds into your same account. Operation rejected.'));
        }
    }
    
}
