<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use app\models\Setting;
use app\models\User;
use yii\db\Query;
use yii\web\UploadedFile;

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
        $file = UploadedFile::getInstance($model,'file');
        if ($file)
            $model->avatar = $file->name;
    	if ($model->load(Yii::$app->request->post()) && $model->save() && $user->load(Yii::$app->request->post()) && $user->save() )
         {
             if ($file){
                 $uploaded = $file->saveAs(Yii::$app->params['avatarPath'].$file->name);
                 $image=Yii::$app->image->load(Yii::$app->params['avatarPath'].$file);
                 $image->resize(100);
                 $image->save();
             }
             Yii::$app->getSession()->setFlash('success', 'The account is successfully updated');
             return $this->redirect(['update']);
         }
        return $this->render('update', ['model' => $model, 'user'=>$user]);
    }

    public function actionEdit($id) {
        if( Yii::$app->user->can('superadmin') ){
            $model = $this->loadModel($id);
            $user = User::findOne(['id'=>$id]);
            if( isset($_POST['User']['password_'])  ){
                if( $password_= $_POST['User']['password_'] ){
                     $user->setPassword($password_);
                     $user->generateAuthKey();
                }
                $user->role = $_POST['User']['role'];
                $user->parent_id = $_POST['User']['parent_id'];
                if ( $user->save() ) return $this->redirect(['user/index','type_user'=>4]);
            }
            return $this->render('edit', ['model' => $model, 'user'=>$user ]);
        }
        else  {
            Yii::$app->getSession()->setFlash('success', 'The user is successfully updated');
            return $this->redirect(['site/index']);
        }
    }


    public function actionAjax_parent() {
        if( Yii::$app->request->isAjax ){
            $role = $_POST['role'];
            $parent = User::getParentArray($role);
            $i = 0;
            foreach( $parent as $key=>$val)
            {
                if( $i == 0 ) echo '<option selected="" value="'.$key.'">'.$val.'</option>';
                else  echo '<option  value="'.$key.'">'.$val.'</option>';
                $i++;
            }
         //   if( !$i ) echo '<option selected="" value="0">Not found</option>';
        }
    }

    public function loadModel($id) {
	     $model= Setting::findOne(['user_id' => $id]);
        
        if($model===null) throw new HttpException(404,'The requested page does not exist.');
        return $model;
    }

}
