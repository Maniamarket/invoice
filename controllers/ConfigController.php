<?php

class ConfigController extends Controller {
/*
    public function actionIndex() {
	$file = dirname(__FILE__) . '../../../config/params.inc';
	$content = file_get_contents($file);
	$arr = dirname(__FILE__) . '../../../config/params.inc';
	$model = new ConfigForm();
	$model->setAttributes($arr);

	if (isset($_POST['ConfigForm'])) {
	    $config = array(
		'adminEmail' => $_POST['ConfigForm']['adminEmail'],
		'paramName' => $_POST['ConfigForm']['paramName'],
	    );
	    $str = base64_encode(serialize($config));
	    file_put_contents($file, $str);
	    Yii::app()->user->setFlash('config', Yii::t('app', 'Your new options have been saved.'));
	    $model->setAttributes($config);
	}

	$this->render('index', array('model' => $model));
    }
    */
    public function actionIndex() {
	
	//echo Yii::app()->config->getConfig();
	//$a = new FileConfig();
	//echo $a->getValue('language');
	print_r(MyHelper::getParamValue('languages')) ;
	
	
	
    }
    
    

}

?>