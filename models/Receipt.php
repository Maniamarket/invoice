<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\Company;
use app\models\Lang;
use app\models\Vat;
use app\models\Payment;
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
class Receipt extends ActiveRecord {

    public $file;

    public static function tableName() {	return 'receipt';    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return [
            [['user_id','title', 'description'], 'required'],
            [['title', 'description'], 'string', 'max' => 200],
            [['logo'], 'safe'],
            ['file', 'file', 'extensions' => ['jpg','jpeg','png','gif']],

        ];
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
            'user_id' => Yii::t('app', 'ID user'),
            'title' => Yii::t('app', 'title'),
            'logo' => Yii::t('app', Yii::t('app', 'Logo')),
            'description' => Yii::t('app', Yii::t('app', 'Description')),
        );
    }


    public static function model($className = __CLASS__) {
    	return parent::model($className);
    }
}
