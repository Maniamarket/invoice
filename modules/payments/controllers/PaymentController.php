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
                //$history->summ = $model->out_summ;
                //$history->curr = $model->in_curr;
               // $history->curs = Yii::$app->cfg->getItem('RUR_USD');

                $history = new Models\PaymentHistory;
                $history->amount = $model->out_summ;
                $history->payment_system_id = 1;
                $history->description = 'PayPal: РїРѕРїРѕР»РЅРµРЅРёРµ РЅР° ' . $model->amount;
                $history->curs = 1;
                $history->equivalent = $model->amount * $history->curs;
                $history->type = $model->type;
                $history->save();
                
               // $model->inv_desc = 'РџРѕ РєСѓСЂСЃСѓ Р¦Р‘, СЃ РІР°СЃ Р±СѓРґРµС‚ СѓРґРµСЂР¶Р°РЅРѕ ' . number_format($model->out_summ, 2, ',', ' ') . ' СЂСѓР±Р»РµР№. $1 = ' . $history->curs . ' RUR';

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
        /* РёСЃРїРѕР»СЊР·СѓРµС‚СЃСЏ РІ СЃР»СѓС‡Р°Рµ СѓСЃРїРµС€РЅРѕРіРѕ РїСЂРѕРІРµРґРµРЅРёСЏ РѕРїР»Р°С‚С‹ */
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
        /* Р’ СЃР»СѓС‡Р°Рµ СѓСЃРїРµС€РЅРѕРіРѕ РёСЃРїРѕР»РЅРµРЅРёСЏ РїР»Р°С‚РµР¶Р° РџРѕРєСѓРїР°С‚РµР»СЊ РјРѕР¶РµС‚ РїРµСЂРµР№С‚Рё РїРѕ РґР°РЅРЅРѕРјСѓ Р°РґСЂРµСЃСѓ. */
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
        /* Р’ СЃР»СѓС‡Р°Рµ РѕС‚РєР°Р·Р° РѕС‚ РёСЃРїРѕР»РЅРµРЅРёСЏ РїР»Р°С‚РµР¶Р° РџРѕРєСѓРїР°С‚РµР»СЊ РїРµСЂРµРЅР°РїСЂР°РІР»СЏРµС‚СЃСЏ РїРѕ РґР°РЅРЅРѕРјСѓ Р°РґСЂРµСЃСѓ */
        Yii::$app->user->setFlash('warning', 'РџР»Р°С‚РµР¶ РѕС‚РјРµРЅРµРЅ.');
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
                echo '<div class="flash-info">РЎ РІР°СЃ Р±СѓРґРµС‚ СѓРґРµСЂР¶Р°РЅРѕ <b>' . $summ . '</b> СЂСѓР±Р»РµР№</div>';
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
//        $text = '1) РџСЂРѕРµРєС‚ - Pay4Date.com<br />';
//        $text.= '2) РЎСѓРјРјР° - $' . $summ . '<br />';
//        $text.= '3) РЎРёСЃС‚РµРјР° РїРѕРїРѕР»РЅРµРЅРёСЏ  - ' . $system . '<br />';
//        $text.= '4) Р”Р°С‚Р°  - ' . date('Y-m-d H:i:s') . '<br />';
//        $text.= '5) РџСЂРѕС„РёР»СЊ РїРѕР»СЊР·РѕРІР°С‚РµР»СЏ  - ' . CHtml::link(Yii::$app->createUrl("/user/user_profile", array("id" => $user_id)), array("/user/user_profile", "id" => $user_id)) . '<br />';
//        mail("service@hochumogu.com", '=?utf-8?B?' . base64_encode("Pay4Date: РћРїРѕРІРµС‰РµРЅРёРµ Рѕ РїРѕРїРѕР»РЅРµРЅРёРё") . '?=', $text, $headers, '-fno-reply@pay4date.com');
//    }
}
