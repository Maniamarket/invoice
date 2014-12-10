<?php

class PaypalController extends Controller {

    public function init() {
        $this->layout = '//layouts/column2';
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('notify'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'), //любой пользователь, включая анонимного.
            ),
        );
    }

    public function actionIndex() {
        $model = new PaypalForm;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'paypal-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['PaypalForm'])) {
            $model->attributes = $_POST['PaypalForm'];
            if ($model->validate()) {
                $history = new PaymentHistory;
                $history->summ = $model->amount;
                $history->curr = 'PayPal: пополнение на $'.$model->amount;
                $history->curs = Yii::app()->cfg->getItem('RUR_USD');
                $history->outSum = $model->amount * $history->curs;
                $history->typeid = PaymentHistory::PT_PAYPAL;
                $history->save();
                $this->layout = '//layouts/column1';
                $this->render('processing', array(
                    'amount' => $model->amount,
                    'user' => Yii::app()->user->getModel(),
                    'pp_id' => $history->id, // номер счета
                ));
                Yii::app()->end();
            }
        }

        $this->render('pay_form', array('model' => $model));
    }

    public function actionNotify() {
        // read the post from PayPal system and add 'cmd'
        $req = 'cmd=' . urlencode('_notify-validate');
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.paypal.com'));
        $res = curl_exec($ch);
        curl_close($ch);

        if (strcmp($res, "VERIFIED") == 0) {
            $pp_id = $_POST['custom']; //номер счета
            $currency = $_POST['mc_currency'];
            $status = $_POST['payment_status'];
            $receiver_email = $_POST['receiver_email'];
            if ($currency == 'USD' && $status == 'Completed' && $receiver_email == 'tetven@gmail.com' && $pp_id) {
                $record = PaymentHistory::model()->findByAttributes(array('id' => $pp_id, 'complete' => 0));
                if ($record) {
                    //TODO: Счет подтвержден - пометить завершенным
                    $record->complete = 1;
                    $record->save();
                    EmailNotification::SendPaymentInfo($record);
                }
            } else {
                $this->write_log($_POST);
            }
        } else if (strcmp($res, "INVALID") == 0) {
            // log for manual investigation
            $this->write_log($_POST);
        }
        $this->redirect(array('payment/history'));
    }

    public function write_log($mixed) {
        ob_start();
        pr($mixed);
        $data = ob_get_contents();
        Yii::log($data, 'trace', 'app.notify.PaypalController');
        ob_end_clean();
    }

}