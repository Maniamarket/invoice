<?php
namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "vat".
 *
 * The followings are the available columns in table 'vat':
 * @property integer $id
 * @property string $name
 * @property integer $percent
 */
class Payment extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			['name', 'required'],
            ['name', 'string', 'max'=>100],
            ['data', 'safe'],

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
			'name' => 'Name',
		);
	}


    public static function getBankData() {
        return unserialize(self::find()->where(['id' => 3])->one()['data']);
    }

    public static function getPayPalData() {
        return unserialize(self::find()->where(['id' => 2])->one()['data']);
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
