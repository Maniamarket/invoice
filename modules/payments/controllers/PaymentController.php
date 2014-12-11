<?php

namespace app\modules\payments\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\modules\payments\models as Models;
use yii\web\Request;

class PaymentController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    /* [
                      'allow' => true,
                      'actions' => ['index', 'view'],
                      'roles' => ['@'],
                      ], */
                    [
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {

        $model = new Models\PaymentForm;

        if (Yii::$app->request->isPost && isset($_POST['PaymentForm'])) {

            $model->attributes = $_POST['PaymentForm'];
            if ($model->validate()) {

                $history = new PaymentHistory;
                $history->summ = $model->out_summ;
                $history->curr = $model->in_curr;
                $history->curs = Yii::$app->cfg->getItem('RUR_USD');

                $history->outSum = $model->out_summ = $model->out_summ * $history->curs;
                $model->inv_desc = 'По курсу ЦБ, с вас будет удержано ' . number_format($model->out_summ, 2, ',', ' ') . ' рублей. $1 = ' . $history->curs . ' RUR';

                if ($history->save()) {
                    $model->inv_id = $history->id;
                    $model->generateCRC();
                    $history->signature = $model->crc;
                    $history->signatureValidate = $model->validateCRC();
                    $history->save();
                    $this->render('roboform', array(
                        'model' => $model,
                    ));
                    Yii::$app->end();
                } else {
                    throw new CHttpException(404, Yii::t('payment', 'An error occurred during payment process. Try to pay later. We apologize for any technical nuisance.'));
                }
            }
        }

        $this->render('buy', array('model' => $model, 'user' => Yii::$app->user->getModel()));
    }

    public function actionResult() {
        /* используется в случае успешного проведения оплаты */
        $inv_id = Yii::$app->request->getParam('InvId', 0);
        $out_summ = Yii::$app->request->getParam('OutSum', 0);
        $signature = Yii::$app->request->getParam('SignatureValue', 0);

        $history = new PaymentHistory;
        $attributes = array();
//        $attributes['signature'] = $signature;
        $attributes['id'] = $inv_id;
        $attributes['complete'] = 0;
        $record = $history->findByAttributes($attributes);

        if ($record) {
            $record->complete = 1;
            $record->save();
            EmailNotification::SendPaymentInfo($record);
        }

        Yii::log(print_r($_REQUEST, true), 'info', 'application.credits.Result');
        Yii::$app->end();
    }

    public function actionSuccess() {
        /* В случае успешного исполнения платежа Покупатель может перейти по данному адресу. */
        $inv_id = Yii::$app->request->getParam('InvId', 0);
        $history = new PaymentHistory;
        $attributes = array();
        $attributes['id'] = $inv_id;
        $attributes['uid'] = Yii::$app->user->getId();
        $attributes['complete'] = 1;
        $record = $history->findByAttributes($attributes);
        if ($record) {
            $this->render('success', array('record' => $record, 'user' => Yii::$app->user->getModel()));
        } else {
            $this->redirect("/user/profile");
        }
    }

    public function actionFail() {
        /* В случае отказа от исполнения платежа Покупатель перенаправляется по данному адресу */
        Yii::$app->user->setFlash('warning', 'Платеж отменен.');
        $inv_id = Yii::$app->request->getParam('InvId', 0);
        $history = new PaymentHistory;
        $attributes = array();
        $attributes['id'] = $inv_id;
        $attributes['uid'] = Yii::$app->user->getId();
        $attributes['complete'] = 0;
        $history->deleteAllByAttributes($attributes);
        $this->redirect("/user/profile");
    }

    public function actionHistory() {
        $model = new PaymentHistory('search');
        $model->unsetAttributes();  // clear any default values
        $model->uid = Yii::$app->user->getId();
        if (isset($_GET['PaymentHistory']))
            $model->attributes = $_GET['PaymentHistory'];

        $this->render('history', array(
            'model' => $model,
        ));
    }

    public function actionUpdate() {
        if (isset($_POST['PaymentForm']) && Yii::$app->request->isAjaxRequest) {
            $model = new PaymentForm;
            $model->attributes = $_POST['PaymentForm'];
            if ($model->validate()) {
                $summ = number_format(($model->out_summ * Yii::$app->cfg->getItem('RUR_USD')), 2, ',', ' ');
                echo '<div class="flash-info">С вас будет удержано <b>' . $summ . '</b> рублей</div>';
            }
        }
    }

    public function renderSumm($data, $row) {
        if ($data->summ > 0) {
            $color = 'green';
        } else {
            $color = '#D84A38';
        }
        $summ = number_format(abs($data->summ), 2, ',', '');
        return '<font color="' . $color . '">$' . $summ . '</font>';
    }

//
//    public static function payment_notification($summ, $system, $user_id) {
//        $headers = "From: Pay4Date <no-reply@pay4date.com>\n";
//        $headers.= "Reply-To: Pay4Date <no-reply@pay4date.com>\n";
//        $headers.= "X-Mailer: PHP/" . phpversion() . "\n";
//        $headers.= "MIME-Version: 1.0" . "\n";
//        $headers.= "Content-type: text/html; charset=utf-8\n";
//        $text = '1) Проект - Pay4Date.com<br />';
//        $text.= '2) Сумма - $' . $summ . '<br />';
//        $text.= '3) Система пополнения  - ' . $system . '<br />';
//        $text.= '4) Дата  - ' . date('Y-m-d H:i:s') . '<br />';
//        $text.= '5) Профиль пользователя  - ' . CHtml::link(Yii::$app->createUrl("/user/user_profile", array("id" => $user_id)), array("/user/user_profile", "id" => $user_id)) . '<br />';
//        mail("service@hochumogu.com", '=?utf-8?B?' . base64_encode("Pay4Date: Оповещение о пополнении") . '?=', $text, $headers, '-fno-reply@pay4date.com');
//    }
}
