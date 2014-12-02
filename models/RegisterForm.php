<?php

/**
 * RegisterForm class.
 * RegisterForm is the data structure for keeping
 * user registration form data. It is used by the 'register' action of 'SiteController'.
 */
class RegisterForm extends CFormModel {

    public $user_id;
    public $name;
    public $password;
    public $register_date;
    public $last_login;
    public $is_on;
    public $role;
    public $country;
    public $city;
    public $street;
    public $post_index;
    public $phone;
    public $web_site;
    public $mail;
    public $vat_number;
    public $activity;
    public $resp_person;
    public $bank_code;
    public $account_number;
    
    public $verifyCode;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username, password & email are required,
     * and username & email needs to be unique.
     */
    public function rules() {
	return array(
	    array('name, password, mail', 'required'),
	    //array('is_on, role, parent_id, post_index', 'numerical', 'integerOnly' => true),
	    array('password, name, country, city, street, phone, web_site, mail, vat_number, activity, resp_person', 'length', 'max' => 255),	    
	    //array('verifyCode', 'captcha', 'message' => 'Error captcha is not correct'),
	    array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'message' => 'Error captcha is not correct'),
	);
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
	return array(
	    'id' => 'ID',
	    'user_id' => 'User',
	    'password' => 'Password',
	    'name' => 'Name',
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
	    'bank_code' => 'Bank Code',
	    'activity' => 'Activity',
	    'account_number' => 'Account number',
	    'resp_person' => 'Resp Person',
	    'verifyCode' => 'Captcha',
	);
    }

}
