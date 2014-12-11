<?php

namespace app\modules\payments\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\payments\models as Models;

class PaypalController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['notify', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $PaypalForm = new Models\PaypalForm;
        $PaymentCurrency = new Models\PaymentCurrency;

        if (isset($_POST['PaypalForm'])) {
            $PaypalForm->attributes = $_POST['PaypalForm'];

            if ($PaypalForm->validate()) {
                $currency = $PaymentCurrency->getCurrencyById($PaypalForm->currency);

                $history = new Models\PaymentHistory;
                $history->amount = $PaypalForm->amount;
                $history->currency_id = $currency->id;
                $history->curs = $currency->curs;

                $history->equivalent = $PaymentCurrency->getEquivalent($history->amount, $history->curs);

                $history->payment_system_id = 1;
                $history->description = 'Пополнение на ' . $history->amount . ' кредитов';

                $history->type = Models\PaymentHistory::PT_PAYPAL;
                $history->save();

                return $this->render('processing', array(
                            'PaypalForm' => $PaypalForm,
                            'history' => $history,
                            'user' => Yii::$app->user->identity,
                ));
                Yii::$app->end();
            }
        }

        $activeCurrency = $PaymentCurrency->getActiveCurrency();
        return $this->render('pay_form', array('model' => $PaypalForm, 'activeCurrency' => $activeCurrency));
    }

    public function actionNotify() {

        file_put_contents(realpath(dirname(__FILE__)) . '/test.txt', $_POST);
      die;
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

        file_put_contents('test.txt', '$res');
        if (strcmp($res, "VERIFIED") == 0) {
            //if (1) {
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

        //$this->redirect(array('payment/history'));
    }

    public function write_log($mixed) {
        ob_start();
        // pr($mixed);
        $data = ob_get_contents();
        Yii::log($data, 'trace', 'app.notify.PaypalController');
        ob_end_clean();
    }

}
