<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction_banktransfer".
 *
 * @property integer $id
 * @property integer $t_id
 * @property integer $user_id
 * @property string $status
 * @property string $type
 * @property integer $date
 */
class Transactionbanktrans extends \yii\db\ActiveRecord {

    public $username;
    /**
     * @inheritdoc
     */
    public static function tableName() {
	return 'transaction_banktransfer';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
	    [['t_id', 'user_id', 'status', 'type', 'date'], 'required'],
	    [['t_id', 'user_id', 'date'], 'integer'],	    
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'id' => 'ID',
	    't_id' => 'Transaction ID',
	    'user_id' => 'Username',
	    'status' => 'Status',
	    'type' => 'Type',
	    'date' => 'Date',
	];
    }

}
