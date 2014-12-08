<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Query;

use app\models\User;
use app\models\Setting;
use app\models\Invoice;

class UserController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'set_tax', 'update'],
                'rules' => [
                    [
                        'actions' => ['create', 'index'],
                        'allow' => true,
                        'roles' => ['manager'],
                    ],
                    [
                        'actions' => ['set_tax', 'update'],
                        'allow' => true,
                        'roles' => ['superadmin'],
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
    public function actionBuy($id) {
        var_dump($id);        exit();
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        $hearder = $this->getHeader($type_user);
        return $this->render('index',['dataProvider'=>$dataProvider, 'hearder' => $hearder, 'type_user' => $type_user ]);
   }

    /**
     * Lists all models.
     */
    public function actionPay($id) {
        $invoice = Invoice::findOne($id);
        if( $invoice->user_id == Yii::$app->user->id)
        {
           $price = Invoice::getPriceTax($invoice);
           $credit = Setting::find()->where(['user_id'=>$invoice->user_id])->one();
           if( $price > $credit->credit) {
               echo 'пополните кредиты';
           }
           else{
              $credit->credit = $credit->credit - $price; 
              $credit->save();
          //    var_dump($credit->credit);              exit();
              $invoice->is_pay = TRUE; 
              
              if($credit->save() && $invoice->save() ) return $this->redirect(['invoice/index']);
              else echo 'сбой прт снятии кредитов';
           }
        }
        else echo 'Это не ваша фактура';
   }

    /**
     * Lists all models.
     */
    public function actionIndex($type_user = 1) {
        $query = $this->getQueri($type_user);
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        $hearder = $this->getHeader($type_user);
        return $this->render('index',['dataProvider'=>$dataProvider, 'hearder' => $hearder, 'type_user' => $type_user ]);
   }

    public function actionUpdate($user_id) {
           if( Yii::$app->request->isAjax)
                {      
                    $model = Setting::find()->where(['user_id' => $user_id])->one();
                    $post = Yii::$app->request->post();
                    $model->surtax = $post['surtax'];
                    $model->save();
                    echo $model->surtax;
                }
   }

    /**
     * Lists all models.
     */
    public function actionSet_tax( $page = 1) {
/*        $query = new Query;
	$query->select(['update_cache'])->from('{{user}}')->orderBy('update_cache','desc')->offset(0)->limit(2);
	$data = $query->createCommand()->queryAll();    */
        $pagen_service = Yii::$app->pagenService;

        $q = new Query;
        $count = $q ->select(['count(*) as kol'])->from('{{user}}')->createCommand()->queryOne();
        $q = new Query;
        $q ->select(['u.*','s.surtax'])->from('{{user}} as u')
                ->join('join','{{setting}} as s',' u.id = s.user_id ')
                ->orderBy('id');
    
        $data_all = $pagen_service->getPaginat($count, $q,6,5,$page);
        $datas = $data_all['values'];
        $pages = $data_all['pages'];
        $page = $data_all['page'];
     
        return $this->render('settax',['datas'=>$datas, 'pages'=> $pages, 'page' => $page ]);
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
