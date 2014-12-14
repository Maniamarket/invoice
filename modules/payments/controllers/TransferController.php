<?php

namespace app\modules\payments\controllers;

use yii\web\Controller;

class TransferController extends Controller {

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
        $owner = Yii::$app->user->getModel();
        if ($this->isWebmaster) {
            $this->layout = 'application.modules.webmaster.views.layouts.webmaster';
        }
        $model = new TrasferForm;
        if (isset($_POST['TrasferForm'])) {
            $model->attributes = $_POST['TrasferForm'];
            if ($model->validate()) { 
                $paymentConfirm = new PaymentConfirm;
                $paymentConfirm->data = serialize($model->attributes);
                $paymentConfirm->user_id = $owner->id;
                $paymentConfirm->getHash();
                if ($paymentConfirm->save()) {
                    /* нет подтвержденного телефона, шлем письмо на почту */
                    if (!$owner->phone_confirm) {
                        $lang = $owner->getLanguageText();
                        $body = $this->renderPartial('//mail/transfer_confirm_code_' . $lang, array('hash' => $paymentConfirm->hash, 'data' => $model->attributes, 'date' => date('Y-m-d H:i:s', time())), TRUE);
                        
                        $params = array('user'=> $user);
                        Email::send($user->email, 'RTB System', $body, $params);
                        $successText = Yii::t('app', 'Email with a security code has been sent to {mail}. Please check email. Security code will be active during the day.', array('{mail}' => '<b>' . $user->email . '</b>'));
                    } else {
                        /* есть телефон - шлем СМС-код */
                        $sms_message = 'Transfer money. Amount: $' . $model->amount . ' to ' . $model->email . '. Confirmation Code: ' . $paymentConfirm->hash;
                        SMS::send($owner->phone, $sms_message);
                        $successText = Yii::t('app', 'On the phone number {pnum} has been send SMS message.', array('{pnum}' => '<b>' . $owner->phone . '</b>'));
                    }

                    Yii::$app->user->setFlash('success', $successText);
                    $this->redirect(array('confirm'));
                } else {
                    Yii::$app->user->setFlash('error', Yii::t('app', 'Error writing to database'));
                }
            }
        }
        $this->render('index', array('model' => $model, 'owner' => $owner));
    }

    /**
     * Событие принимает код протекции.
     * В случае успеха проводит транзакцию по переводу стредств
     * <b>ВНИМАНИЕ!</b> Испольуется хранимая MySQL-процедура
     * @todo корректно обработать ответ $command->execute()
     * @author Ranuk Alexey <lex161@gmail.com>
     * @return view HTML
     */
    public function actionConfirm() {

        $modelForm = new PaymentConfirm;

        if (isset($_POST['PaymentConfirm'])) {
            $modelForm->attributes = $_POST['PaymentConfirm'];
            if ($modelForm->validate()) {
                $criteria = new CDbCriteria;
                $criteria->select = 'id, data';
                $criteria->condition = '`hash`="' . $modelForm->hash . '" AND `user_id`=' . Yii::$app->user->getId() . ' AND `dateAdded`>=NOW() - INTERVAL 1 DAY ';
                /* ищем код протекции не старше одного дня */
                $model = PaymentConfirm::model()->find($criteria);

                if (is_object($model)) {
                    $data = unserialize($model->data);
                    $recipient = User::model()->findByAttributes(array('email' => $data['email']));
                    $sender = Yii::$app->user->getModel();

                    /* вызов хранимой процедуры */
                    $model->_setSecretKey('payment_key');
                    $command = Yii::$app->db->createCommand('CALL transferMoney(:sender,:recipient,:amount,:operator,:description);');
                    $command->bindValue(':sender', $sender->id, PDO::PARAM_INT);
                    $command->bindValue(':recipient', $recipient->id, PDO::PARAM_INT);
                    $command->bindValue(':amount', $data['amount'], PDO::PARAM_INT);
                    $command->bindValue(':operator', NULL, PDO::PARAM_NULL);
                    $command->bindValue(':description', $data['info'], PDO::PARAM_STR);
                    $command->execute();

                    /* удалить запись (код протекции) PaymentConfirm, предотвращение повторного вывода. */
                    $model->delete();

                    /* уведомление на екране. */
                    $message = Yii::t('mypurse', 'Transfer money for {user} complete!', array('{user}' => '<b>' . $recipient->email . '</b>'));
                    Yii::$app->user->setFlash('success', $message);

                    /* email transfer notification for admin */
                    $body = $this->renderPartial('//mail/transfer_admin_notification', array('senderEmail' => $sender->email, 'data' => $data), TRUE);
                    Email::send(Yii::$app->params['transferNotificationEmail'], 'RTB System', $body);

                    /* phone transfer notification for admin */
                    $message = $sender->email . ' transfer $' . $data['amount'] . ' to ' . $recipient->email;
                    SMS::send(Yii::$app->params['transferNotificationPhone'], $message);
                    $this->redirect(array('/mypurse/info'));
                } else {
                    Yii::$app->user->setFlash('error', Yii::t('app', 'Security code is invalid. Or the validity of the security code has expired.'));
                }
            }
        }

        $this->render('confirm', array('model' => $modelForm));
    }

}
