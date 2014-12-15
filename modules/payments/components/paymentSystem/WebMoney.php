<?php

class WebMoney extends Payment implements iPayment {

    const LMI_SECRET_KEY = '8WYg98AjX{#04LxU@aZ?KP~UC';
    const LMI_PAYEE_PURSE = 'Z321635403105';
    const LMI_MODE = 0;

    public function getLogo() {
        return '//www.webmoney.ru/img/icons/wmlogo_48.png';
    }

    public function getUrl() {
        return 'www.webmoney.ru';
    }

    public function getName() {
        return 'WebMoney';
    }

    public function getMethod() {
        return 'post';
    }

    public function getAction() {
        return 'https://merchant.webmoney.ru/lmi/payment.asp';
    }

    public function getFormName() {
        return 'webmoney';
    }

    public function getParams(PaymentHistory $history) {
        $description = Yii::$app->name . '. ' . Yii::t('mypurse', 'Payer') . ': ' . $history->user->email . '. ' . $history->getDescription();
        return array(
            'LMI_PAYMENT_AMOUNT' => $history->amount,
            'LMI_PAYMENT_DESC_BASE64' => base64_encode($description),
            'LMI_PAYMENT_NO' => $history->id,
            'LMI_PAYEE_PURSE' => self::LMI_PAYEE_PURSE,
            'LMI_SIM_MODE' => self::LMI_MODE,
                //'LMI_PAYMER_EMAIL' => $history->user->email,
                /*
                  0 или отсутствует: Для всех тестовых платежей сервис будет имитировать успешное выполнение;
                  1: Для всех тестовых платежей сервис будет имитировать выполнение с ошибкой (платеж не выполнен);
                  2: Около 80% запросов на платеж будут выполнены успешно, а 20% - не выполнены.
                 */
        );
    }

    public function checkSign() {
        Yii::log('Start function checkSign(){}', 'info', 'mypurse.' . get_class($this));
        if (isset($this->request['LMI_SYS_INVS_NO'])) {
            $str = self::LMI_PAYEE_PURSE .
                    $this->request['LMI_PAYMENT_AMOUNT'] .
                    $this->request['LMI_PAYMENT_NO'] .
                    $this->request['LMI_MODE'] .
                    $this->request['LMI_SYS_INVS_NO'] .
                    $this->request['LMI_SYS_TRANS_NO'] .
                    $this->request['LMI_SYS_TRANS_DATE'] .
                    self::LMI_SECRET_KEY .
                    $this->request['LMI_PAYER_PURSE'] .
                    $this->request['LMI_PAYER_WM'];
            Yii::log(strtoupper(md5($str)), 'checkSign str', 'mypurse.' . get_class($this));
            return ($this->request['LMI_HASH'] === strtoupper(md5($str)));
        }
        Yii::log('function checkSign(){} return FALSE;', 'error', 'mypurse.' . get_class($this));
        return false;
    }

    public function setResult() {
        Yii::log('Start function setResult(){}', 'info', 'mypurse.' . get_class($this));
        if (isset($this->request['LMI_PAYMENT_NO'])) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id = :id AND complete = 0';
            $criteria->params = array(':id' => $this->request['LMI_PAYMENT_NO']);
            $this->setCriteria($criteria);
            return parent::setResult();
        }
    }

    public function setSuccess() {
        if (isset($this->request['LMI_PAYMENT_NO'])) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'id = :id AND complete = 1';
            $criteria->params = array(':id' => $this->request['LMI_PAYMENT_NO']);
            $this->setCriteria($criteria);
            return parent::setSuccess();
        }
        return false;
    }

    public function getCurrency($purseNumber) {

        $key = strtoupper(substr($purseNumber, 0, 1));

        switch ($key) {
            case 'Z';
                return 'USD';
                break;
            case 'U';
                return 'UAH';
                break;
            case 'R';
                return 'RUR';
                break;
            case 'E';
                return 'EUR';
                break;
        }
    }

    public function getScenario() {
        return 'webmoney';
    }

}
