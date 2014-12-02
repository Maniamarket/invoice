<?php

class SettingController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
	return array(
	    'accessControl', // perform access control for CRUD operations
	    'postOnly + delete', // we only allow deletion via POST request
	);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
	$this->render('view', array(
	    'model' => $this->loadModel($id),
	));
    }

    protected function getDefaultCompany() {
	$companyArray = CHtml::listData(Company::model()->findAll(), 'id', 'name');
	return $companyArray;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
	$model = new Setting;

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['Setting'])) {
	    $model->attributes = $_POST['Setting'];
	    $model->setAttribute('user_id', Yii::app()->user->id);
	    if ($model->save())
		$this->redirect(array('view', 'id' => $model->id));
	}

	$this->render('create', array(
	    'model' => $model,
	));
    }
    public function actionCredit() {
	$model = new Setting;

	$this->render('credit', array(
	    'model' => $model,
	));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
	$model = $this->loadModel(Yii::app()->user->id);

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['Setting'])) {
	    $model->attributes = $_POST['Setting'];
	    $model->setAttribute('role', $_POST['Setting']['role']);
	    if ($model->save()) {
		User::model()->updateByPk(Yii::app()->user->id, array(
		    'role' => $model->role));
		$this->redirect(array('update'));
	    }
	}

	$this->render('update', array(
	    'model' => $model,
	));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
	$this->loadModel($id)->delete();

	// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	if (!isset($_GET['ajax']))
	    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
	$dataProvider = new CActiveDataProvider('Setting');
	$this->render('index', array(
	    'dataProvider' => $dataProvider,
	));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
	$model = new Setting('search');
	$model->unsetAttributes();  // clear any default values
	if (isset($_GET['Setting']))
	    $model->attributes = $_GET['Setting'];

	$this->render('admin', array(
	    'model' => $model,
	));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Setting the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
	$model = Setting::model()->findByPk($id);
	if ($model === null)
	    throw new CHttpException(404, 'The requested page does not exist.');
	return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Setting $model the model to be validated
     */
    protected function performAjaxValidation($model) {
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'setting-form') {
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
    }

}
