<?php
namespace app\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $id
 * @property string $name
 */
class Company extends ActiveRecord {

    public $file;
    /**
     * @return string the associated database table name
     */
    public static function tableName() {
	return 'company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
	// NOTE: you should only define rules for those attributes that
	// will receive user inputs.
	return array(
            [['name','mail'], 'required'],
            [['mail'], 'unique'],
            ['mail','email'],

            ['name', 'string', 'max' => 255],
            [
                ['name', 'city','street','phone','phone2','fax','web_site','mail','vat_number','tax_agency','activity','resp_person'],
                'filter', 'filter' => 'trim'
            ],
            [
                ['city','street','phone','phone2','fax','web_site','mail','vat_number','tax_agency','activity','resp_person'],
                'string', 'max' => 100
            ],
            [['post_index','country_id'], 'integer', 'integerOnly' => true],
	    ['file', 'file', 'extensions' => ['jpg','jpeg','png','gif']],
	    // The following rule is used by search().
	    // @todo Please remove those attributes that should not be searched.
	    ['id, name', 'safe', 'on' => 'search'],
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
	    'name' => 'Name',
	    'logo' => 'Company Logo',
	    'country' => 'Country',
	    'city' => 'City',
	    'street' => 'Street',
	    'post_index' => 'Post Index',
        'phone' => 'Phone',
        'phone2' => 'Phone Second',
        'fax' => 'Fax',
	    'web_site' => 'Web Site',
	    'mail' => 'Mail',
	    'vat_number' => 'Vat Number',
	    'activity' => 'Activity',
	    'tax_agency' => 'Tax Agency',
	);
    }

    public function getCountry()
    {
        return $this->hasOne('app\models\Country', ['cid' => 'country_id']);
        // Первый параметр – это у нас имя класса, с которым мы настраиваем связь.
        // Во втором параметре в виде массива задаётся имя удалённого PK ключа  (id) и FK из текущей таблицы модели (author_id), которые связываются между собой
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

	$criteria->compare('id', $this->id);
    $criteria->compare('name', $this->name, true);

	return new CActiveDataProvider($this, array(
	    'criteria' => $criteria,
	));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Company the static model class
     */
    public static function model($className = __CLASS__) {
	return parent::model($className);
    }

}
