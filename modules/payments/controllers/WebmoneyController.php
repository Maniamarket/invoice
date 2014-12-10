<?php

class WebmoneyController extends Controller {

    const LMI_PAYEE_PURSE = 'Z310766237213'; //Кошелек продавца
    const LMI_SECRET_KEY = 'JEPcj0wcvjheiowp'; //Secret Key
    const LMI_MODE = 0; //Флаг тестового режима

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
                'actions' => array('result'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'), //любой пользователь, включая анонимного.
            ),
        );
    }

    public function actionIndex() {
        $model = new PaypalForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'webmoney-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PaypalForm'])) {
            $model->attributes = $_POST['PaypalForm'];
            if ($model->validate()) {
                $history = new PaymentHistory;
                $history->summ = $model->amount;
                $history->curr = 'WebMoney: пополнение на $' . $model->amount;
                $history->curs = Yii::app()->cfg->getItem('RUR_USD');
                $history->outSum = $model->amount * $history->curs;
                $history->typeid = PaymentHistory::PT_WM;
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

    public function actionResult() {
        Yii::log(print_r($_REQUEST, true), 'info', 'application.credits.WMResult');
        if (isset($_REQUEST['LMI_SYS_INVS_NO'])) {
            if ($this->checkSign($_REQUEST)) {
                $record = PaymentHistory::model()->findByAttributes(array('id' => $_REQUEST['LMI_PAYMENT_NO'], 'complete' => 0));
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
        Yii::log(print_r($_REQUEST, true), 'info', 'application.credits.WMSuccess');
        $user = Yii::app()->user->getModel();
        if (isset($_REQUEST['LMI_PAYMENT_NO'])) {
            $record = PaymentHistory::model()->findByAttributes(array('id' => $_REQUEST['LMI_PAYMENT_NO'], 'complete' => 1));
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
        Yii::log(print_r($_REQUEST, true), 'info', 'application.credits.WMFail');
        $this->render('fail', array('user' => Yii::app()->user->getModel()));
    }

    public function checkSign($data) {
        $str = self::LMI_PAYEE_PURSE . $data['LMI_PAYMENT_AMOUNT'] . $data['LMI_PAYMENT_NO'] . self::LMI_MODE . $data['LMI_SYS_INVS_NO'] . $data['LMI_SYS_TRANS_NO'] . $data['LMI_SYS_TRANS_DATE'] . self::LMI_SECRET_KEY . $data['LMI_PAYER_PURSE'] . $data['LMI_PAYER_WM'];
        return ($data['LMI_HASH'] === strtoupper(md5($str)));
    }

}