<?php

namespace app\modules\payments\controllers;

use yii\web\Controller;

class FailController extends CallbackController {

    public function process($model) {
        $model->setFail();
        Yii::$app->user->setFlash('error', Yii::t('app', 'Your payment has been canceled.'));
        $this->redirect('/mypurse');
    }

}