<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\Company;
use app\models\Lang;
use app\models\Vat;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
 * @property integer $user_id
 * @property integer $credit
 * @property integer $vat
 * @property integer $def_company
 * @property integer $def_lang
 */
class User_payment extends ActiveRecord {

    public static function tableName() {
	return 'user_payment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
	// NOTE: you should only define rules for those attributes that
	// will receive user inputs.
	return array(
	    [['user_id','credit', 'credit_sum', 'profit_parent', 'is_input','date'], 'required'],
	    [['user_id', 'is_input'], 'integer'],
	    [['user_id','credit', 'is_input'], 'integer','integerOnly' => FALSE],
	 //   [['date'], 'integer','integerOnly'=>FALSE],
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
	    'user_id' => 'User',
	    'credit' => 'Credit',
	);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
	// @todo Please modify the following code to remove attributes that should not be searched.

	$criteria = new CDbCriteria;

	$criteria->compare('user_id', $this->user_id);
	$criteria->compare('credit', $this->credit);
	$criteria->compare('vat', $this->vat);
	$criteria->compare('def_company', $this->def_company);
	$criteria->compare('def_lang', $this->def_lang);

	return new CActiveDataProvider($this, array(
	    'criteria' => $criteria,
	));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Setting the static model class
     */
    public static function model($className = __CLASS__) {
	return parent::model($className);
    }

}
