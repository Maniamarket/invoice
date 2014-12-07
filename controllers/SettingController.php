<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Request;
use yii\web\HttpException;
use app\models\Setting;

class SettingController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
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
    public function actionUpdate()
    {
        $model = $this->loadModel(Yii::$app->user->id);
	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if ($model->load(Yii::$app->request->post()) && $model->save()) 
         {  
            return $this->redirect(['site/index']);   
         }
        else  return $this->render('update', ['model' => $model,]);
    }

    public function loadModel($id) {
	$model= Setting::find()->where(['user_id' => $id])->one();
        
        if($model===null) throw new HttpException(404,'The requested page does not exist.');
        return $model;
    }

}
