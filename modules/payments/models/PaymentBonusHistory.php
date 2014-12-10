<?php

/**
 * This is the model class for table "tbl_payment_bonus_history".
 *
 * The followings are the available columns in table 'tbl_payment_bonus_history':
 * @property integer $id
 * @property integer $uid
 * @property double $summ
 * @property string $date
 */
class PaymentBonusHistory extends CActiveRecord {
    
     public $amount_bonus_in;   
     public $amount_bonus_out;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentBonusHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tbl_payment_bonus_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date', 'required'),
            array('uid', 'numerical', 'integerOnly' => true),
            array('summ', 'numerical'),
            array('descr', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, uid, summ, date, descr', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'uid' => 'Uid',
            'summ' => Yii::t('payment', 'Amount'),
            'descr' => Yii::t('payment', 'Description'),
            'date' => Yii::t('payment', 'Date'),
        );
    }

    public function add($userId, $summ, $descr) {
        $this->uid = $userId;
        $this->summ = $summ;
        $this->descr = $descr;
        $this->date = time();
        $this->save();
    }
    
    public function createChatPayment($uid, $recipientId, $invite) {

        $pay = new PaymentHistory();
        $payBonus = new PaymentBonusHistory();
        $pay->curr = "Видеосвидание с пользователем ";

        
            $sender = User::model()->findByPk($uid);
            $senderBalance = (float) $sender->getSumm();
            $bonusBalance = $sender->getBonus();
            $bonusBalanceFull = $sender->getBonusFull();
            if (($senderBalance + $bonusBalance) < (float) ($invite->lastSumm / 60)) {
                return false;
            }
            
            $amount = -(float) $invite->lastSumm / 60;
            $pay->curr .=$recipientId;
            $pay->complete = 1;
            $pay->date = date('Y-m-d H:i:s', time());
            $pay->recipientId = $recipientId;
            $pay->senderId = $uid;
            $pay->uid = $uid;
            $pay->typeid = PaymentHistory::PT_CHAT_TRANSACTION;

            $payBonus->uid = $uid;
            $payBonus->descr = $pay->curr;
            $payBonus->date = time();
            if($bonusBalanceFull < (float) ($invite->lastSumm / 60)){
                $payBonus->summ = $bonusBalanceFull * (-1);
                $pay->summ = $amount + $bonusBalanceFull;
            } else {
                $payBonus->summ = $amount;
                $pay->summ = 0;
            }
            
            
            if ($pay->save()) {
                $payBonus->senderTr = $pay->id;
                $payBonus->save();
                return $pay->id;
                
            }

            return false;
    }

    
   
    
     public function updateChatPayment($senderTranId, $recipientTranId, $invite) {
         $amount = (float) $invite->lastSumm / 60;
         $pay = new PaymentHistory();
        
        // sender Tranzaction 
        $senderTransaction = $pay->findByPk($senderTranId);
        if (!$senderTransaction) {
            return false;
        }
        $sender = User::model()->findByPk($senderTransaction->senderId);
        if (!$sender) {
            return false;
        }
        $senderBalance = (float) $sender->getSumm();
        $senderBonusBalance = (float) $sender->getBonus();
        $senderBonusBalanceFull = $sender->getBonusFull();
        if ($senderBonusBalanceFull == 0) return false;
        // recipient Tranzaction
        $recipientTransaction = $pay->findByPk($recipientTranId);
        if (!$recipientTransaction) {
            return false;
        }
        
        // bonus Tranzaction
        $bonusTransaction = $this->find('senderTr = :senderTr', array(':senderTr'=>$senderTranId));
        if (!$bonusTransaction) {
            return false;
        }

        if (($senderBalance + $senderBonusBalanceFull) < $amount) {
            return false;
        }

        $senderTransaction->date = date('Y-m-d H:i:s', time());
        $recipientTransaction->date = date('Y-m-d H:i:s', time());
        $bonusTransaction->date = time();
        
        if($senderBonusBalanceFull < $amount){
            $bonusTransaction->summ = $senderBonusBalanceFull;
            $senderTransaction->summ-=$amount- $senderBonusBalance;
            $recipientTransaction->summ+=$amount * 0.8;
        } else {
            $bonusTransaction->summ -= $amount;
            $senderTransaction->summ-=0;
            $recipientTransaction->summ+=$amount * 0.8;
        }

        if ($senderTransaction->validate() && $recipientTransaction->validate()) {
            $senderTransaction->save();
            $recipientTransaction->save();
            $bonusTransaction->save();
            return true;
        }
        return false;
    }
    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('uid', Yii::app()->user->getId());
        $criteria->compare('summ', $this->summ);
        $criteria->compare('descr', $this->descr, true);
        $criteria->compare('date', $this->date, true);
        $criteria->order = 'id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function formatID($id = null) {
        $formatValue = ($id) ? $id : $this->id;
        return implode('-', str_split(sprintf("%016d", $formatValue), 4));
    }
    
    public function formatDate($mktime){
        return date('Y-m-d H:i:s', $mktime);
    }
    
    public function setChatAttributes($userId) {
        $this->uid = $userId;
        $this->summ = -Yii::app()->cfg->getItem('UNBLOCK_CHAT');
        $this->descr = "Разблокирован контакт за $this->summ долларов";
    }

}