<?php

class CallbackController extends CController {

    public function actionIndex($model) {
        Yii::log(print_r($_REQUEST, true), 'info', 'mypurse.' . get_class($this));
        if (class_exists($model) && in_array('PaymentConfiguration', class_implements($model))) {
            $payment = new $model();
            $payment->setRequest($_REQUEST);
            $this->process($payment);
            Yii::app()->end();
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    public function process($model) {
        
    }

}
