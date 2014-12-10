<?php
namespace app\modules\payments\controllers;

use yii\web\Controller;

class ResultController extends CallbackController {

    public function process($model) {
        if ($model->checkSign()) {
            
            $history = $model->setResult();
            
            $message = $history->user->email;
            $message .= ' popolnenie na $';
            $message .= $history->amount;
            SMS::send('+380634915712', $message);
            $model->sendResponse($history);
        }
    }

}