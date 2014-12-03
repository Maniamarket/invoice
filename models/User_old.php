<?php
namespace app\models;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $user_id
 * @property string $password
 * @property string $name
 * @property string $register_date
 * @property string $last_login
 * @property integer $is_on
 * @property integer $role
 * @property integer $parent_id
 * @property string $country
 * @property string $city
 * @property string $street
 * @property integer $post_index
 * @property string $phone
 * @property string $web_site
 * @property string $mail
 * @property string $vat_number
 * @property string $activity
 * @property string $resp_person
 */
class User extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, password, name, register_date, last_login', 'required'),
			array('is_on, role, parent_id, post_index', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			array('password, name, country, city, street, phone, web_site, mail, vat_number, activity, resp_person', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, password, name, register_date, last_login, is_on, role, parent_id, country, city, street, post_index, phone, web_site, mail, vat_number, activity, resp_person', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'password' => 'Password',
			'name' => 'Company Name',
			'register_date' => 'Register Date',
			'last_login' => 'Last Login',
			'is_on' => 'Is On',
			'role' => 'Role',
			'parent_id' => 'Parent',
			'country' => 'Country',
			'city' => 'City',
			'street' => 'Street',
			'post_index' => 'Post Index',
			'phone' => 'Phone',
			'web_site' => 'Web Site',
			'mail' => 'Mail',
			'vat_number' => 'Vat Number',
			'activity' => 'Activity',
			'resp_person' => 'Resp Person',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('register_date',$this->register_date,true);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('is_on',$this->is_on);
		$criteria->compare('role',$this->role);
		//$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('post_index',$this->post_index);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('web_site',$this->web_site,true);
		$criteria->compare('mail',$this->mail,true);
		$criteria->compare('vat_number',$this->vat_number,true);
		$criteria->compare('activity',$this->activity,true);
		$criteria->compare('resp_person',$this->resp_person,true);

		$check = MyHelper::checkAccess(Yii::app()->user->role);
		//echo (int)$check;
		if (!empty($check)) {	   
		    $criteria->compare('parent_id', $this->parent_id);
		} else {	    
		    $criteria->compare('parent_id', Yii::app()->user->id);
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
