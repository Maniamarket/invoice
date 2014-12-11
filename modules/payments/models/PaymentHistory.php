<?php

namespace app\modules\payments\models;

use Yii;
use \yii\db\ActiveRecord;
use \yii\base\Model;

/**
 * This is the model class for table "tbl_payment_history".
 *
 * The followings are the available columns in table 'tbl_payment_history':
 * @property string $id
 * @property string $user_id
 * @property string $operator_id
 * @property double $amount
 * @property string $currency
 * @property double $curs
 * @property double $equivalent
 * @property string $description
 * @property string $date
 * @property string $payment_system_id
 * @property integer $complete
 * @property integer $type
 * The followings are the available model relations:
 * @property paymentSystem $paymentSystem
 * @property user $user
 * @property user $operator
 * @property paymentOutput $paymentOutput
 */
class PaymentHistory extends ActiveRecord {

    const PT_MANUAL = 10;
    const PT_MONEY_TRANSFER = 20;
    const PT_PAYPAL = 30;

    public function init() {
        $this->type = self::PT_MANUAL;
        $this->complete = 0;
        parent::init();
    }

    public static function tableName() {
        return 'payment_history';
    }

    public function rules() {
        return array(
            [['amount', 'payment_system_id'], 'required'],
            [['user_id', 'payment_system_id', 'complete', 'type', 'operator_id'], 'integer'],
            [['amount'], 'double'],
            [['description'], 'string', 'max' => 255],
            [['id', 'user_id', 'amount', 'description', 'date', 'payment_system_id', 'complete', 'type', 'date',], 'safe', 'on' => 'search'],
        );
    }

    public function relations() {
        return array(
            'paymentSystem' => array(self::BELONGS_TO, 'PaymentSystem', 'payment_system_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'operator' => array(self::BELONGS_TO, 'User', 'operator_id'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('payment', 'ID'),
            'user_id' => Yii::t('payment', 'User'),
            'operator_id' => Yii::t('payment', 'Operator'),
            'amount' => Yii::t('payment', 'Amount'),
            'description' => Yii::t('payment', 'Description'),
            'date' => Yii::t('payment', 'Date'),
            'complete' => Yii::t('payment', 'Status'),
            'type' => Yii::t('payment', 'Payment Type'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id, false);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('complete', $this->complete);
        $criteria->compare('type', $this->type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.date DESC, t.type ASC',
                'attributes' => array(
                    'userEmail' => array(
                        'asc' => 'user.email ASC',
                        'desc' => 'user.email DESC',
                    ),
                    '*', // add all of the other columns as sortable
                ),
            ),
            'pagination' => array(
                'pageSize' => Yii::$app->user->getState('pageSize', Yii::$app->params['defaultPageSize']),
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave($insert) {
        //$this->_setSecretKey('payment_key');
        if (empty($this->description) && $this->payment_system_id) {
            $this->description = 'Top-up through {model}. To the amount of ${amount}';
        }
        return parent::beforeSave($insert);
    }

    public function getDate($format = 'd M Y') {
        return date($format, strtotime($this->date));
    }

    public function getStatus() {
        return ($this->complete) ? Yii::t('payment', 'Complete') : Yii::t('payment', 'Not Complete');
    }

    public function getCssClass() {
        return ($this->complete) ? 'complete' : 'complete fail';
    }

    public function getType() {
        switch ($this->type) {
            case self::PT_MANUAL:
                return Yii::t('payment', 'manual');
                break;
            case self::PT_MONEY_TRANSFER:
                return Yii::t('payment', 'transfer');
                break;
            case self::PT_PAYPAL:
                return Yii::t('payment', 'paypal');
                break;
        }
    }

    public function afterSave($insert, $changedAttributes) {
        //send email about payment
        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete() {
        return parent::beforeDelete();
    }

    public static function balanceToDay($uid, $date) {
        return Yii::$app->db->createCommand()
                        ->select('ROUND(SUM(`amount`),2) AS `amount`')
                        ->from('payment_history')
                        ->where('user_id = :uid AND complete = 1 AND DATE(`date`) <= :date', array(':uid' => $uid, ':date' => $date))
                        ->queryScalar();
    }

}
