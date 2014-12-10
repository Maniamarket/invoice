<?php

class Payment {

    protected $request;
    protected $criteria;

    public function __construct() {
        
    }

    public function getId() {
        $model = PaymentSystem::model()->findByAttributes(array('model' => get_class($this)));
        return $model->id;
    }

    public function setRequest($data) {
        $this->request = $data;
    }

    public function setCriteria(CDbCriteria $criteria) {
        $this->criteria = $criteria;
    }

    public function setResult() {
        $record = PaymentHistory::model()->find($this->criteria);
        if ($record) {
            $record->complete = 1;
            $record->information = base64_encode(serialize($this->request));
            $record->save();
            return $record;
        }
        return false;
    }

    public function sendResponse($history = NULL) {
        
    }

    public function setSuccess() {
        return PaymentHistory::model()->find($this->criteria);
    }

    public function setFail() {
        
    }

    public function getCurrency($paymentSystemInfo) {
        return 'EUR';
    }

    public function getField(CActiveForm $form, PaymentOutput $model) {
        return $form->textField($model, 'paymentSystemInfo', array('class' => 'text'));
    }

    public function getScenario() {
        return 'default';
    }

}
