<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Company;
use yii\web\Request;
use yii\web\UploadedFile;

class CompanyController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions'=>['login','error'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
    ];
}
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        return $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
	$model = new Company;
//    $dir = Yii::getAlias('@web/images');
    $uploaded = false;

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (Yii::$app->request->isPost) {
	   
//	   print_r($_FILES);
	   $model->attributes = $_POST['Company'];
	   //$model->logo = $_FILES;
	   //echo '<pre>'; print_r($model->attributes); 
//	   $model->logo = CUploadedFile::getInstance($model,'logo');
	   //print_r($model->logo->tempName); exit;
	   
	  //print_r($model->attributes); exit;
        $file = UploadedFile::getInstance($model,'file');
        if ($file)
            $model->logo = $file->name;
	    if ($model->save()) {
            if ($file)
                $uploaded = $file->saveAs('images/companies/'.$file->name);

//		$model->logo->saveAs(Yii::app()->basePath . '/../www/images/logo/' . $model->logo);
		
//		$image = Yii::$app->image->load(Yii::app()->basePath . '/../www/images/logo/' . $model->logo);
//		$image->resize(200, 200);
//		$image->save();
		
		
		$this->redirect(array('view', 'id' => $model->id));
	    }
	}

	return $this->render('create', array(
	    'model' => $model,
        'uploaded' => $uploaded,
	));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
	$model = $this->loadModel($id);
    $uploaded = false;

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['Company'])) {
        $file = UploadedFile::getInstance($model,'file');
        if ($file)
            $model->logo = $file->name;
	    $model->attributes = $_POST['Company'];
	    if ($model->save()) {
            if ($file)
                $uploaded = $file->saveAs('images/companies/'.$file->name);
            $this->redirect(array('view', 'id' => $model->id));
        }
	}

	return $this->render('update', array(
	    'model' => $model,
        'uploaded' => $uploaded,
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
	    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionRemove() {
        $id = Yii::$app->request->post('id');
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
/*        if (Yii::$app->user->can('admin'))  // "admin" является названием роли которое было создано через API "authManger"-а.
            echo 'Hello, Admin!';
        else echo 'fatal';*/

        $dataProvider = new ActiveDataProvider([
            'query' => Company::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
	$model = new Company('search');
	$model->unsetAttributes();  // clear any default values
	if (isset($_GET['Company']))
	    $model->attributes = $_GET['Company'];

	$this->render('admin', array(
	    'model' => $model,
	));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Company the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
//        $model = new Company();
        $model = Company::find()
            ->where(['id' => $id])
            ->one();
	if ($model === null)
	    throw new HttpException(404, 'The requested page does not exist.');
	return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Company $model the model to be validated
     */
    protected function performAjaxValidation($model) {
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'company-form') {
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
    }

}
