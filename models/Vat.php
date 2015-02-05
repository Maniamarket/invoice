<?php
namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "vat".
 *
 * The followings are the available columns in table 'vat':
 * @property integer $id
 * @property integer $percent
 */
class Vat extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'vat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('percent', 'required'),
			array('percent', 'integer','integerOnly'=>FALSE),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('id, percent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',			
			'percent' => 'Percent',
		);
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Vat the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
