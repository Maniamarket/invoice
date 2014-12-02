<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property string $id
 * @property string $date
 * @property string $name
 * @property string $company
 * @property integer $price
 * @property integer $pay
 */
class Invoice extends CActiveRecord {
    public $currency;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
	return 'invoice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
	// NOTE: you should only define rules for those attributes that
	// will receive user inputs.
	return array(
	    array('currency, date, name, user_id, company, service, price, count', 'required'),
	    array('price,count,vat,discount', 'numerical', 'integerOnly' => true),
	    array('id', 'length', 'max' => 15),
	    array('name, company', 'length', 'max' => 255),
	    // The following rule is used by search().
	    // @todo Please remove those attributes that should not be searched.
	    array('id, date, name, company, price, pay', 'safe', 'on' => 'search'),
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
	    'user_id' => Yii::t('lang','InvoiceClientNameText'),
	    'date' => Yii::t('lang','InvoiceDateText'),
	    'name' => Yii::t('lang','InvoiceNameText'),
	    'service' => Yii::t('lang','InvoiceServiceText'),
	    'company' => Yii::t('lang','InvoiceCompanyText'),
	    'price' => Yii::t('lang','InvoicePriceText'),
	    'currency' => Yii::t('lang','InvoiceCurrencyText'),
	    'pay' => 'Pay',
	    'count' => Yii::t('lang','InvoiceCountText'),
	    'vat' => Yii::t('lang','InvoiceVATText').' (%)',
	    'discount' => Yii::t('lang','InvoiceDiscountText'),
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

	$criteria->compare('id', $this->id, true);
	$criteria->compare('date', $this->date, true);
	$criteria->compare('name', $this->name, true);
	$criteria->compare('company', $this->company, true);
	$criteria->compare('price', $this->price);
	$criteria->compare('pay', $this->pay);

	$check = MyHelper::checkAccess(Yii::app()->user->role);
	//echo (int)$check;
	if (!empty($check)) {	   
	    $criteria->compare('user_id', $this->user_id);
	} else {	    
	    $criteria->compare('user_id', Yii::app()->user->id);
	}


	return new CActiveDataProvider($this, array(
	    'criteria' => $criteria,
	));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Invoice the static model class
     */
    public static function model($className = __CLASS__) {
	return parent::model($className);
    }

}
