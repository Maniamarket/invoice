<?php
namespace app\controllers;

use Yii;
use yii\helpers\Url;
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
        $setting = new Setting();
        if ($model->load(Yii::$app->request->post())) {
            $id_t = yii::$app->user->id;
            $role = $this->getRole($type_user);
            if ( $user = $model->signup($role,$id_t )) {
                $user->status = 10;
                if( $user->save() ) {
                    $setting->load(Yii::$app->request->post());
                    $setting->user_id = $user->id;
                    $setting->def_lang_id = 1;
                    $setting->bank_code = 'no';
                    $setting->account_number = 'no';
                    if( $setting->save()) return $this->redirect(['index', 'type_user' => $type_user]);
                }
            }
        }
        return $this->render('signup', [ 'model' => $model,'setting'=>$setting]);
    }

    /**
     * Lists all models.
     */
    public function actionBuy() {
        if (Yii::$app->user->can('user')) {
            $id = Yii::$app->user->id;
            $model = new User_payment;
            $model->credit = (isset($_REQUEST['cost'])) ? $_REQUEST['cost'] : 0;
            if (isset($_POST['payment'])) {
                $pay = (isset($_POST['payment'])) ? $_POST['payment'] : 0 ;
                switch ($pay) {
                    case 1 : return $this->redirect(['payment_credit', 'id' => $id, 'payment_id' => $pay]);
                    case 2 : return $this->redirect(['payment_credit', 'id' => $id, 'payment_id' => $pay]);
                    case 3 : return $this->redirect(['/paymentbanktrans/create']);
                    default : return $this->render('buy', ['model'=>$model]);
                }
            }
            return $this->render('buy', ['model'=>$model]);
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
            $model->credit = (isset($_REQUEST['cost'])) ? $_REQUEST['cost'] : 0;
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
    public function actionAdd_credit($id) {
            $model = Setting::findOne(['user_id'=>$id]);
            $add_credit = 0;
            $error = '';
            if( isset($_POST['add_credit']) ){
                $add_credit = $_POST['add_credit'];
                if( is_numeric( $add_credit)){
                    $model->credit = $model->credit + $add_credit;
                    if( $model->save()){
                        $model = new User_payment;
                        $model->user_id = $id;
                        $model->is_input = 1;
                        $model->credit = $add_credit;
                        $model->profit_parent = $model->profit_parent + 0;
                        $model->txn_id = 1;
                        $old = User_payment::find()->where(['user_id'=>$id])->orderBy(['id'=>SORT_DESC])->one();
                        $model->credit_sum = ( $old ) ? $old->credit_sum + $add_credit : $add_credit;
                        $model->date = new Expression('NOW()');
                        $model->save();
                        Yii::$app->getSession()->setFlash('success', 'Success. Add credit '.$add_credit.' for user #'.$id);

                        return $this->redirect(['index','type_user'=>4]);
                    }
                }
                else $error = 'Error! must number';
            }

            return $this->render('add_credit',['model' => $model, 'add_credit'=>$add_credit, 'error'=>$error]);
    }

    /**
     * Lists all models.
     */
    public function actionPay($id) {
        $invoice = Invoice::findOne($id);
        if( $invoice->user_id == Yii::$app->user->id)
        {
            $credit = Setting::findOne(['user_id'=>$invoice->user_id]);
            $vat = $invoice->vat->percent;
            $income  = $invoice->income;
            $price_tek = $invoice->net_price*($vat + $income)/100;
            if( $price_tek > $credit->credit) {
               Yii::$app->getSession()->setFlash('danger', 'Вам надо пополнить кредиты на сумму '.
                       round($price_tek).' кредита');
               return $this->redirect(['buy', 'id'=>$invoice->user_id]);
            }
            else{
              $credit->credit = $credit->credit - $price_tek; 
              $invoice->is_pay = TRUE;
              if($credit->save() && $invoice->save() ){
     //valid kod
                  $transaction = Yii::$app->db->beginTransaction();
                  try {
                      $q = 'select valid_kod from invoice order by valid_kod desc limit 0,1';
                      $valid_kod = Yii::$app->db->createCommand($q)->queryScalar();

                      $invoice->valid_kod = $valid_kod+1;
                      $invoice->save();
                      $transaction->commit();
                  } catch (Exception $e) {
                      $transaction->rollBack();
                      Yii::$app->getSession()->setFlash('danger', 'Error. Validation kod not save');
                  }
     //оплата налогов (история)
                  $model = new User_payment;  
                  $model->user_id = $invoice->user_id;
                  $model->is_input = 0;
                  $model->credit = - $invoice->net_price*$income/100;
                  $model->txn_id = -$invoice->id;
                  $old = User_payment::find()->where(['user_id'=>$invoice->user_id])->orderBy(['id'=>SORT_DESC])->one();
                  if( $old ){
                      $model->credit_sum =  $old->credit_sum - $price_tek;
                      $model->profit_parent = $model->profit_parent + $invoice->net_price*$income/100;
                  }else{
                      $model->credit_sum =  - $price_tek;
                      $model->profit_parent = $invoice->net_price*$income/100;
                  }
                  $model->date = new Expression('NOW()');
                  $model->save();
                  Yii::$app->getSession()->setFlash('success', 'Invoice payment №MM100'.$invoice->id);

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
                'pagination' => [ 'pageSize' => 6, ],
            ]);
        $hearder = $this->getHeader($type_user);
        Yii::$app->getSession()->set('url_user',Url::toRoute(['user/index','type_user'=>$type_user]));
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
            $model = Setting::findOne(['user_id' => $user_id]);
            $model->surtax = $_POST['surtax'];
            $model->save();
            echo $model->surtax;
        }
    }

    /**
     * Lists all models.
     */
    public function actionSet_tax( $page = 1) {
         $dataProvider = new ActiveDataProvider([
                'query' => User::find(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        return $this->render('settax',['dataProvider'=>$dataProvider]);
   }

    public function getQueri($type_user) {
        switch ( $type_user ){
            case  1 : $res = User::find()->select('u.id, u.name, ui.credit, ui.profit_manager,'
                    . ' (select SUM( us_in.credit) from user_income as us_in where us_in.user_id = u.id ) as sum_profit ')
                    ->from('user u')->leftJoin('user_income ui','u.id = ui.user_id  and MONTH(ui.date) = MONTH(NOW()) ');
                   if( Yii::$app->user->identity->role !== 'superadmin') $res->where(['u.parent_id' => Yii::$app->user->id,
                       'u.role' => "user"]);
                   return $res;
            case  2 : $res = User::find()->select('u.id, u.name, ui.credit, ui.profit_manager, ui.income, ui.my_profit,'
                . ' (select SUM( us_in.credit) from user_income as us_in where us_in.user_id = u.id ) as sum_profit, '
                . ' (select SUM( us_in.profit_manager) from user_income as us_in where us_in.user_id = u.id ) as sum_profit_manager')
                ->from('user u')->leftJoin('user_income ui','u.id = ui.user_id  and MONTH(ui.date) = MONTH(NOW()) ');
                if( Yii::$app->user->identity->role !== 'superadmin') $res->where(['u.parent_id' => Yii::$app->user->id,
                    'u.role' => "manager"]);
                  return $res;
            case  3 : $res = User::find()->select('u.id, u.name, ui.credit, ui.profit_manager, ui.profit_admin,ui.income, ui.my_profit,'
                . ' (select SUM( us_in.credit) from user_income as us_in where us_in.user_id = u.id ) as sum_profit, '
                . ' (select SUM( us_in.profit_admin) from user_income as us_in where us_in.user_id = u.id ) as sum_profit_admin, '
                . ' (select SUM( us_in.profit_manager) from user_income as us_in where us_in.user_id = u.id ) as sum_profit_manager')
                ->from('user u')->leftJoin('user_income ui','u.id = ui.user_id  and MONTH(ui.date) = MONTH(NOW()) ')
                ->where(['u.role' => 'admin']);
                return $res;
            case  4 : $res = User::find()->select('u.id, u.name, ui.credit, ui.profit_manager, s.surtax,'
                . ' (select SUM( us_in.credit) from user_income as us_in where us_in.user_id = u.id ) as sum_profit')
                ->from('user u')->leftJoin('user_income ui','u.id = ui.user_id  and MONTH(ui.date) = MONTH(NOW()) ')
                ->leftJoin('setting s', 'u.id = s.user_id' ) ;
                return $res;
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
            case  1 : return Yii::t('app', 'My Users');
            case  2 : return Yii::t('app', 'My Managers');
            case  3 : return Yii::t('app', 'My Admins');
            case  4 : return Yii::t('app', 'All Users');
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
