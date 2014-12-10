<?php

namespace app\modules\payments\controllers;

use yii\web\Controller;

class InfoController extends Controller {

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'users' => array('@')
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex() {
        $model = new PaymentHistory('searchLast');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentHistory'])) {
            $model->attributes = $_GET['PaymentHistory'];
        }
        $model->setAttribute('user_id', Yii::app()->user->getId());
        $user = Yii::app()->user->getModel();
        $payForm = new PayForm;
        if (isset($_POST['PayForm'])) {
            $payForm->attributes = $_POST['PayForm'];
            if ($payForm->validate()) {
                $history = new PaymentHistory;
                $history->user_id = Yii::app()->user->getId();
                $history->amount = $payForm->amount;
                $history->payment_system_id = $payForm->payment_system_id;

                $history->currency = Currency::DEFAULT_CURRENCY;
                $history->curs = Currency::getUSDCrossCurs($history->currency);
                $history->equivalent = round($history->amount * Currency::getUSDCrossCurs($history->currency), 2);
                $history->save();

                $config = $history->paymentSystem->getConfig();
                $params = $config->getParams($history);

                $this->render('processing_form', array(
                    'config' => $config,
                    'params' => $params,
                ));
                Yii::app()->end();
            }
        }

        if (!$user->phone_confirm) {
            $accountLink = CHtml::link(Yii::t('app', 'account'), '/user/profile');
            $text = Yii::t('app', 'After confirming your phone number - all financial transactions will occur with his participation. That will greatly enhance the safety of your funds.');
            $text .= ' ' . Yii::t('app', 'Add your phone number in the settings of your {account}.', array('{account}' => $accountLink));
            Yii::app()->user->setFlash('notice', $text);
        }

        $this->render('index', array(
            'user' => $user,
            'payForm' => $payForm,
            'model' => $model
        ));
    }

}
