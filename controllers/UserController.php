<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use app\models\SignupForm;

class UserController extends Controller {

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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
	$model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $model = new \app\models\Setting();
                    $model->user_id = Yii::$app->getUser()->id;
                    $model->def_company_id = 0;
                    $model->def_lang_id = 0;
                    $model->bank_code = 'no';
                    $model->account_number = 'no';
                    $model->save();
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [ 'model' => $model, ]);

    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
	$model = $this->loadModel($id);

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['User'])) {
	    $model->attributes = $_POST['User'];
	    if ($model->save())
		$this->redirect(array('view', 'id' => $model->id));
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
        $dataProvider = new ActiveDataProvider([
                'query' => User::find()->where(['manager_id'=>  Yii::$app->user->id]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        return $this->render('index',array( 'dataProvider'=>$dataProvider, ));
   }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
	$model = new User('search');
	$model->unsetAttributes();  // clear any default values
	if (isset($_GET['User']))
	    $model->attributes = $_GET['User'];

	$this->render('admin', array(
	    'model' => $model,
	));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return User the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
	$model = User::model()->findByPk($id);
	if ($model === null)
	    throw new CHttpException(404, 'The requested page does not exist.');
	return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param User $model the model to be validated
     */
    protected function performAjaxValidation($model) {
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
    }

}
