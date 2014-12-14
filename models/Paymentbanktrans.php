<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "payment_bt".
 *
 * @property integer $id
 * @property string $message
 * @property string $file
 */
class Paymentbanktrans extends \yii\db\ActiveRecord {

    public $username;
    /**
     * @inheritdoc
     */
    public static function tableName() {
	return 'payment_bt';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
	return [
	    [['message', 'file','sum'], 'required'],
	    ['file', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif']],
	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
	return [
	    'id' => 'ID',
	    'username' => 'User',
	    'sum' => 'Sum',	    
	    'message' => 'Message',
	    'file' => 'File',
	    'status' => 'Status',
	    'date' => 'Date',
	];
    }

    public function getImageurl() {
	//return Yii::$app->request->BaseUrl . '/<path to image>/' . $this->logo;
	return '/'.Yii::$app->params['creditPath'] . $this->file;
    }

}
