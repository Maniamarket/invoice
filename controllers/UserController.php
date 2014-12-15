<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\db\Expression;
use yii\db\Query;

use app\models\User;
use app\models\Setting;
use app\models\Invoice;
use app\models\User_payment;
use app\models\User_income;

class UserController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index', 'set_tax', 'update'],
                'rules' => [
                    [
                        'actions' => ['create', 'index', 'profit'],
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
	if ($id == Yii::$app->user->id) {
	    if (isset($_POST['payment'])) {
		$pay = $_POST['payment'];
		switch ($pay) {
		    case 1 : return $this->redirect(['payment_credit', 'id' => $id, 'payment_id' => $pay]);
		    case 2 : return $this->redirect(['payment_credit', 'id' => $id, 'payment_id' => $pay]);
		    case 3 : return $this->redirect(['/paymentbanktrans/create']);
		    default : return $this->redirect(['buy']);
		}
		
	    }
	    return $this->render('buy', []);
	} else
	    echo 'Это не для гостей';
    }

    /**
     * Lists all models.
     */
    public function actionPayment_credit($id, $payment_id) {
        if( $id == Yii::$app->user->id)
        {
          $model = new User_payment;  
          if( $model->load(Yii::$app->request->post()) ){
    //увеличение кредитов (история)
              $model->user_id = $id;
              $model->is_input = TRUE;
              $model->credit_sum = 0;
              $model->profit_parent = $model->profit_parent + 0;
              $model->date = new Expression('NOW()');
              
              if( $model->save()){
                switch ( $payment_id ){
                  case  1 : break;
                  case  2 :  return $this->redirect(['pay/paypal','id' => $model->id ]);
                  case  1 : break;
                }                
                   
                return $this->redirect(['invoice/index']);
              }
          }  
          return $this->render('payment_credit',['model' => $model,'payment_id'=>$payment_id]);
        }
        else echo 'Это не для гостей';

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
           $price_tek = $price['vat'] + $price['tax'];
           if( $price_tek > $credit->credit) {
               \Yii::$app->getSession()->setFlash('danger', 'Вам надо пополнить кредиты на сумму '.
                       round($price['vat']+$price['tax']).' кредита');
               return $this->redirect(['buy', 'id'=>$invoice->user_id]);
           }
           else{
              $credit->credit = $credit->credit - $price_tek; 
              $invoice->is_pay = TRUE; 
              
              if($credit->save() && $invoice->save() ){
     //оплата налогов (история)
                  $model = new User_payment;  
                  $model->user_id = $invoice->user_id;
                  $model->is_input = 0;
                  $model->credit = - $price_tek;
                  $old = User_payment::find()->where(['user_id'=>$invoice->user_id])->orderBy(['id'=>SORT_DESC])->one();
                  $model->credit_sum = $old->credit_sum - $price_tek;
                  $model->profit_parent = $model->profit_parent + $price['tax'];
                  $model->date = new Expression('NOW()');
//              var_dump($old->credit_sum );     var_dump($model->credit_sum );              exit();
                  $model->save();
     //сумма налогов за месяц
                  $q = new Query;
                  $isDate =  new Expression('MONTH(`date`)=MONTH(NOW())');
                  $q ->select(['SUM(u.profit_parent) as sum'])->from('{{user_payment}} as u')
                    ->where( $isDate )->andWhere('is_input = 0 and user_id='.$model->user_id);
                  $res = $q->createCommand()->queryOne();
                  if( !$user = User_income::find()->where([ 'user_id'=>$model->user_id])
                          ->andWhere($isDate)->orderBy(['id'=>SORT_DESC])->one())
                       $user = new User_income;
                  $user->parent_id = \Yii::$app->user->identity->parent_id;
                  $user->credit =  $res['sum'];
                  $user->user_id = $invoice->user_id;
                  $user->date = new Expression('NOW()');
                  $user->save();
        //parent manager
                  $q = new Query;
                  $q ->select(['SUM(u.credit) as sum'])->from('{{user_income}} as u')
                    ->where( $isDate )->andWhere('parent_id = '.$user->parent_id);
                  $res = $q->createCommand()->queryOne();
                  if( ! $parent_manager = User_income::find()->where([ 'user_id'=>$user->parent_id ])
                                    ->andWhere($isDate)->orderBy(['id'=>SORT_DESC])->one())
                         $parent_manager = new User_income;
                  $parent_manager->user_id = $user->parent_id;
                  $parent_manager->credit = 0;
                  $parent_manager->date = $user->date;
                  $paren = User::find()->where(['id'=>$user->parent_id])->one();
                  $parent_manager->parent_id = ( $paren )? $paren->parent_id : 0;
                  if( ! $paren) { echo ' добавь в базу user='.$user->parent_id; exit();}
                  elseif( $paren->role == 'manager')     $parent_manager->profit_manager = $res['sum'];
                  elseif($paren->role  == 'admin')  $parent_manager->profit_admin = $res['sum'];
                     
                  $parent_manager->save();
                  
                  if( $parent_manager->parent_id >0 ){
                    $q = new Query;
                    $q ->select(['SUM(u.credit) as sum, SUM(u.profit_manager) as sum_prof'])->from('{{user_income}} as u')
                      ->where( $isDate )->andWhere('parent_id = '.$parent_manager->parent_id);
                    $res = $q->createCommand()->queryOne();
                    if( ! $parent_admin = User_income::find()->where([ 'user_id'=>$parent_manager->parent_id ])
                            ->andWhere($isDate)->orderBy(['id'=>SORT_DESC])->one())
                            $parent_admin = new User_income;  
                        $parent_admin->profit_admin = $res['sum'] + $res['sum_prof'];
                        $parent_admin->credit = 0;
                        $parent_admin->date = $user->date;
                        $parent_admin->parent_id = 0;
     //    var_dump($res['sum_prof']);   var_dump($res['sum']);   var_dump($parent_admin->profit_admin);   exit();
                        $parent_admin->save();
                  }
                  
                  return $this->redirect(['invoice/index']);
              }
              else echo 'сбой прт снятии кредитов';
           }
        }
        else echo 'Это не ваша фактура';
   }

    /**
     * Lists all models.
     */
    public function actionIndex($type_user = 1) {
        if( $type_user >1 ){
            User_income::setIncome();
        }
        $query = $this->getQueri($type_user);
        $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
       //     var_dump($dataProvider);            exit();
        $hearder = $this->getHeader($type_user);
        return $this->render('index',['dataProvider'=>$dataProvider, 'hearder' => $hearder, 'type_user' => $type_user ]);
   }

    /**
     * Lists all models.
     */
    public function actionProfit() {
        $dataProvider = new ActiveDataProvider([
                'query' => User_income::find()->where(['user_id'=> Yii::$app->user->id])->orderBy(['id'=>SORT_DESC]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        return $this->render('profit',['dataProvider'=>$dataProvider]);
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
	$query->select(['update_cache'])->from('{{user}}')->orderBy('update_cache',SORT_DESC)->offset(0)->limit(2);
	$data = $query->createCommand()->queryAll();    */
         $dataProvider = new ActiveDataProvider([
                'query' => User::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        return $this->render('settax',['dataProvider'=>$dataProvider]);
//        return $this->render('settax',['datas'=>$datas, 'pages'=> $pages, 'page' => $page ]);
   }

    public function getQueri($type_user) {
        switch ( $type_user ){
            case  1 : return User::findBySql('select u.id, u.name, ui.credit, ui.profit_manager,'
                    . ' (select SUM( us_in.credit) from user_income as us_in where us_in.user_id = u.id ) as sum_profit '
                    . 'from {{user}} as u '
                    . 'left join {{user_income}} as ui  on ( u.id = ui.user_id  and MONTH(ui.date) = MONTH(NOW()))'
                    . '  where u.parent_id = '.Yii::$app->user->id.' and u.role = "user" ');
            case  2 : return User::findBySql('select u.id, u.name, ui.credit, ui.profit_manager, ui.income, my_profit,'
                    . ' (select SUM( us_in.credit) from user_income as us_in where us_in.user_id = u.id ) as sum_profit, '
                    . ' (select SUM( us_in.profit_manager) from user_income as us_in where us_in.user_id = u.id ) as sum_profit_manager '
                    . 'from {{user}} as u '
                    . 'left join {{user_income}} as ui  on ( u.id = ui.user_id  and MONTH(ui.date) = MONTH(NOW()))'
                    . '  where u.parent_id = '.Yii::$app->user->id.' and u.role = "manager" ');
            case  3 : return User::findBySql('select u.id, u.name, ui.credit, ui.profit_manager, ui.profit_admin,ui.income, my_profit,'
                    . ' (select SUM( us_in.credit) from user_income as us_in where us_in.user_id = u.id ) as sum_profit, '
                    . ' (select SUM( us_in.profit_admin) from user_income as us_in where us_in.user_id = u.id ) as sum_profit_admin, '
                    . ' (select SUM( us_in.profit_manager) from user_income as us_in where us_in.user_id = u.id ) as sum_profit_manager '
                    . 'from {{user}} as u '
                    . 'left join {{user_income}} as ui on ( u.id = ui.user_id  and MONTH(ui.date) = MONTH(NOW()))'
                    . '  where u.parent_id = '.Yii::$app->user->id.' and u.role = "admin" ');
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
