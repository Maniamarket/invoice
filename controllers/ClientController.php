<?php
namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Session;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

use app\models\LoginClientForm;
use app\models\Invoice;
use app\models\Client;

/**
 * Site controller
 */
class ClientController extends Controller
{
    public $layout='client';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','special-callback'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                                return $this->isClient();
                            }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionLogin()
    {
        $model = new LoginClientForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $session = Yii::$app->session;
            $session['client_id'] = $model->id;
            return $this->redirect(array('invoice'));
        } else {
            return $this->render('login', [ 'model' => $model, ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionInvoice()
    {
        $client_id = $this->isClient();

        $dataProvider = new ActiveDataProvider([
                'query' => Invoice::find()->where(['client_id'=>$client_id]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        return $this->render('index',array( 'dataProvider'=>$dataProvider, ));
    }

    public function actionUpdate()
    {
        $client_id = $this->isClient();

        $model = $this->loadModel($client_id);
	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if ($model->load(Yii::$app->request->post()) && $model->save()) 
         {  
            return $this->redirect(['invoice']);   
         }
        else  return $this->render('update', ['model' => $model,]);

    }
    
    public function isClient() 
    {
        return ( isset(Yii::$app->session['client_id'])) ? Yii::$app->session['client_id'] : 0;
    }

    // Match callback called! This page can be accessed only each October 31st
    public function actionSpecialCallback()
    {
        echo 'Работает!';
//        return $this->render('happy-halloween');
    }


    public function loadModel($id) 
    {
	$model= Client::find()->where(['id' => $id])->one();
        if($model===null) throw new HttpException(404,'The requested page does not exist.');
        return $model;
    }


}
