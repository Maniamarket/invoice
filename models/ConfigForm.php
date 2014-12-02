<?php

class ConfigForm extends CFormModel {

    public $adminEmail;
    public $paramName;

    public function rules() {
	return array(
	    array('adminEmail, paramName', 'required'),
	);
    }

}

?>