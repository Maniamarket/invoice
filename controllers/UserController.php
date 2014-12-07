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
    public function actionCreate($type_user) {
	$model = new \app\models\SignupAdminForm();
        if ($model->load(Yii::$app->request->post())) {
            $id_t = \yii::$app->user->id;
            $role = $this->getRole($type_user);
            if ($user = $model->signup($role,$id_t)) {
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
                    return $this->redirect(['index', 'type_user' => $type_user]);
                }
            }
        }
        return $this->render('signup', [ 'model' => $model]);

    }

    /**
     * Lists all models.
     */
    public function actionIndex($type_user = 1) {
        $query = $this->getQueri($type_user);
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
//                'query' => User::find()->where(['manager_id'=>  Yii::$app->user->id]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        $hearder = $this->getHeader($type_user);
        return $this->render('index',['dataProvider'=>$dataProvider, 'hearder' => $hearder, 'type_user' => $type_user ]);
   }

    public function getQueri($type_user) {
        switch ( $type_user ){
            case  1 : return User::find()->where(['parent_id'=>  Yii::$app->user->id, 'role'=>'user']);
            case  2 : return User::find()->where(['parent_id'=>  Yii::$app->user->id, 'role'=>'manager']);
            case  3 : return User::find()->where(['parent_id'=>  Yii::$app->user->id, 'role'=>'admin']);
        }
    }

    public function getRole($type_user) {
        switch ( $type_user ){
            case  1 : return 'user';
            case  2 : return 'manager';
            case  3 : return 'admin';
        }
    }

    public function getHeader($type_user) {
        switch ( $type_user ){
            case  1 : return 'My Users';
            case  2 : return 'My Managers';
            case  3 : return 'My Admins';
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
