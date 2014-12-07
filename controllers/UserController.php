<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;

class UserController extends Controller {

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


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
	$model = new \app\models\SignupAdminForm();
        if ($model->load(Yii::$app->request->post())) {
            $role_admin = \yii::$app->user->identity->role;
            $id_t = \yii::$app->user->id;
            $type = $this->getType($role_admin);  
            if ($user = $model->signup($role_admin,$type)) {
                if (Yii::$app->getUser()->login($user)) {
                    $model = new \app\models\Setting();
                    $model->user_id = Yii::$app->getUser()->id;
                    $model->def_company_id = 0;
                    $model->def_lang_id = 0;
                    $model->bank_code = 'no';
                    $model->account_number = 'no';
                    $model->save();
                    
                    $user = $this->loadModel($id_t);
                    Yii::$app->getUser()->login($user); 
                    return $this->goHome();
                }
            }
        }
        return $this->render('signup', [ 'model' => $model]);

    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
                'query' => User::find()->where(['admin_id'=>Yii::$app->user->id]),
//                'query' => User::find()->where(['manager_id'=>  Yii::$app->user->id]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        return $this->render('index',array( 'dataProvider'=>$dataProvider, ));
   }

    
    public function getType($role) {
        switch ( $role){
            case  'manager' : return 2;
            case  'admin' : return 3;
            case  'superadmin' : return 4;
            default : return 1;   
        }
    }

    
    public function loadModel($id) {
	$model= User::find()->where(['id' => $id])->one();
        if($model===null) throw new HttpException(404,'The requested page does not exist.');
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
