<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Setting;
use app\models\User;
use yii\db\Query;
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
        $user = User::findOne(['id'=>Yii::$app->user->id]);
        if( isset($_POST['User']['password_']) && $password_= $_POST['User']['password_'] ){
            $user->setPassword($password_);
            $user->generateAuthKey();
        }
    	if ($model->load(Yii::$app->request->post()) && $model->save() && $user->load(Yii::$app->request->post()) && $user->save() )
         {
             return $this->redirect(['site/index']);
         }
        return $this->render('update', ['model' => $model, 'user'=>$user]);
    }

    public function actionEdit($id) {
        if( Yii::$app->user->can('superadmin') ){
            $model = $this->loadModel($id);
            $user = User::findOne(['id'=>$id]);
            if( isset($_POST['User']['password_'])  ){
//                if( isset($_POST['User']['password_']) && $password_= $_POST['User']['password_'] ){
           //     $user->setPassword($password_);
             //   $user->generateAuthKey();
                $user->role = $_POST['User']['role'];
                $user->parent_id = $_POST['User']['parent_id'];
                if ( $user->save() ) return $this->redirect(['site/index']);
            }
            return $this->render('edit', ['model' => $model, 'user'=>$user ]);
        }
        else  return $this->redirect(['site/index']);
    }



    public function loadModel($id) {
	     $model= Setting::findOne(['user_id' => $id]);
        
        if($model===null) throw new HttpException(404,'The requested page does not exist.');
        return $model;
    }

}
