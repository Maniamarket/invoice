<?php
namespace app\modules\payments\controllers;

use yii\web\Controller;

class SuccessController extends CallbackController {

    public function process($model) {
        $record = $model->setSuccess();
        if($record){
            Yii::app()->user->setFlash('success', Yii::t('app', 'Your payment is completed.'));
        }
        $this->redirect('/mypurse/info');
    }

}