<?php
namespace app\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\Session;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;

use app\models\LoginClientForm;
use app\models\SignupClientForm;
use app\models\Invoice;
use app\models\Client;

use yii\widgets\ListView;

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
        unset(Yii::$app->session['client_id']);
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    
    public function actionCreate() {
        $this->layout='main';
        $model = new SignupClientForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($client = $model->signup()) {
               // var_dump(Yii::$app->session['password']);                exit();
                return $this->redirect(['index']);
            }
        }

        return $this->render('signup_client', ['model' => $model,]);
    }

    public function actionIndex() {
        $this->layout='main';
        $dataProvider = new ActiveDataProvider([
            'query' => Client::queryProvider(Yii::$app->request->queryParams),
            'pagination' => [
                'pageSize' => 20
            ],
        ]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionAjax() {
        if(!Yii::$app->request->isAjax) throw new ForbiddenHttpException('Url should be requested via ajax only');
        $dataProvider = new ActiveDataProvider([
            'query' => Client::queryProvider(Yii::$app->request->queryParams),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->renderPartial('ajax', ['dataProvider' => $dataProvider]);
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
        return $this->render('invoice',array( 'dataProvider'=>$dataProvider, ));
    }

    public function actionTcpdf($id)
    {
        $model = Invoice::find()->where(['id'=>$id])->one();
        if ($model->client_id == $this->isClient()) {
            $template = isset(Yii::$app->request->queryParams['template'])?Yii::$app->request->queryParams['template']:'basic';
            return $this->render('/invoice/tcpdf', [
                'model' => $model,
                'template'=>$template
            ]);
        } else {
            throw new ForbiddenHttpException('Access to the invoice is forbidden. You are not the owner of the invoice');
        }
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
