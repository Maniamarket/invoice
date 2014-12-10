<?php

class InterkassaController extends Controller {

    const IK_SHOP_ID = '4EFA5C92-48A5-4BEA-2D29-27EE2CBA12A0'; //ID магазина
    const IK_KEY = 'y1P2ThJyzN2rPY8j'; //KEY магазина

    public function init() {
        $this->layout = '//layouts/column2';
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'success', 'fail'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('status'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'), //любой пользователь, включая анонимного.
            ),
        );
    }

    public function actionIndex() {
        $model = new PaypalForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'interkassa-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PaypalForm'])) {
            $model->attributes = $_POST['PaypalForm'];
            if ($model->validate()) {
                $history = new PaymentHistory;
                $history->summ = $model->amount;
                $history->curr = 'Interkassa: пополнение на $' . $model->amount;
                $history->curs = Yii::app()->cfg->getItem('RUR_USD');
                $history->outSum = $model->amount * $history->curs;
                $history->typeid = PaymentHistory::PT_IK;
                $history->save();
                $this->layout = '//layouts/column1';
                $this->render('processing', array(
                    'amount' => $model->amount,
                    'pp_id' => $history->id, // номер счета
                ));
                Yii::app()->end();
            }
        }

        $this->render('pay_form', array('model' => $model));
    }

    public function actionStatus() {
        Yii::log(print_r($_REQUEST, true), 'info', 'application.credits.IKResult');
        if (isset($_REQUEST['ik_payment_id']) && isset($_REQUEST['ik_payment_state']) && $_REQUEST['ik_payment_state'] == 'success') {
            if ($this->checkSign($_REQUEST)) {
                $record = PaymentHistory::model()->findByAttributes(array('id' => $_REQUEST['ik_payment_id'], 'complete' => 0));
                if ($record) {
                    $record->complete = 1;
                    $record->save();
                    EmailNotification::SendPaymentInfo($record);
                }
            }
        }
        Yii::app()->end();
    }

    public function actionSuccess() {
        Yii::log(print_r($_REQUEST, true), 'info', 'application.credits.IKSuccess');
        $user = Yii::app()->user->getModel();
        if (isset($_REQUEST['ik_payment_id'])) {
            $record = PaymentHistory::model()->findByAttributes(array('id' => $_REQUEST['ik_payment_id'], 'complete' => 1));
            if ($record) {
                $this->render('success', array('record' => $record, 'user' => $user));
            } else {
                $this->render('fail', array('user' => $user));
            }
        } else {
            $this->render('fail', array('user' => $user));
        }
    }

    public function actionFail() {
        Yii::log(print_r($_REQUEST, true), 'info', 'application.credits.IKFail');
        $this->render('fail', array('user' => Yii::app()->user->getModel()));
    }

    public function checkSign($status_data) {
        $sing_hash_str = self::IK_SHOP_ID . ':' .
                $status_data['ik_payment_amount'] . ':' .
                $status_data['ik_payment_id'] . ':' .
                $status_data['ik_paysystem_alias'] . ':' .
                $status_data['ik_baggage_fields'] . ':' .
                $status_data['ik_payment_state'] . ':' .
                $status_data['ik_trans_id'] . ':' .
                $status_data['ik_currency_exch'] . ':' .
                $status_data['ik_fees_payer'] . ':' .
                self::IK_KEY;
        $sign_hash = strtoupper(md5($sing_hash_str));
        return ($status_data['ik_sign_hash'] === $sign_hash);
    }

}
