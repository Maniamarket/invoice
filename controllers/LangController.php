<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use app\models\Lang;
use yii\web\Request;


class LangController extends Controller
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
		$model=new Lang;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                 if ($model->load(Yii::$app->request->post()) && $model->save()) {
                        return $this->redirect(['index']);
                 } else 
                        return $this->render('create', ['model' => $model, ]);
	}

	
	public function actionUpdate($id)
	{
                if( Yii::$app->request->isAjax)
                {      
                    $model=$this->loadModel($id);
                    $post = Yii::$app->request->post();
                    $model->name= $post['name'];
                    $model->save();
                    echo $model->name;
                }
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
                'query' => Lang::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            if( yii::$app->user->identity->role==='superadmin' ) return $this->render('index_adm',array( 'dataProvider'=>$dataProvider, ));
            else  return $this->render('index',array( 'dataProvider'=>$dataProvider, ));
	}

	public function loadModel($id)
	{
            $model=Lang::find()->where(['id' => $id])->one();
            
            if($model===null) throw new CHttpException(404,'The requested page does not exist.');
            
            return $model;
	}

}
