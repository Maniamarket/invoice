<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Income;
use yii\web\Request;

class IncomeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions'=>['index'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['superadmin'],
                    ],
                        ],
                ],
            ];
    }


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Income;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                 if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['index']);
                 } else 
                        return $this->render('create', [ 'model' => $model, ]);
	}

	
	public function actionUpdate($id)
	{
           $model = $this->loadModel($id);
           if ($model->load(Yii::$app->request->post()) && $model->save() ) 
            {
           //  $model->validate();  var_dump($model->errors); exit();
                $this->redirect(array('index'));
            }
           else  return $this->render('update', [ 'model' => $model, ]);
        }        

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $dataProvider = new ActiveDataProvider([
                'query' => Income::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            if( yii::$app->user->identity->role==='superadmin' ) return $this->render('index_adm',array( 'dataProvider'=>$dataProvider, ));
            else  return $this->render('index',array( 'dataProvider'=>$dataProvider, ));
	}

	
	public function loadModel($id)
	{
            $model = Income::find()->where(['id' => $id])->one();
            
            if($model===null) throw new CHttpException(404,'The requested page does not exist.');
            
            return $model;
	}
}
