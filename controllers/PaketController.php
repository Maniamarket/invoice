<?php

namespace app\controllers;

use app\models\Receipt;
use Yii;
use app\models\Credit_paket;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LangController implements the CRUD actions for Lang model.
 */
class PaketController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get'],
                ],
            ],
        ];
    }

    /**
     * Lists all Lang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Credit_paket::find()->orderBy(['value'=>SORT_ASC]),
            'pagination' => [ 'pageSize' => 10, ],
        ]);
        $paket = Receipt::findOne(['key'=>'paket']);
        if(isset($_POST['submitPack'])){
            $paket->title = (isset($_POST['active'])) ? '1' : '0';
            $paket->update();
            Yii::$app->getSession()->setFlash('success', 'The settings package is successfully updated');
        }
        return $this->render('index',[ 'dataProvider'=>$dataProvider,'paket'=>$paket]);
    }

    /**
     * Creates a new Lang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Credit_paket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Пакет успешно создан');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [ 'model' => $model, ]);
        }
    }

    /**
     * Updates an existing Lang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Пакет успешно обновлен');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [ 'model' => $model, ]);
        }
    }

    /**
     * Deletes an existing Lang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if(!isset($_GET['ajax'])){
            Yii::$app->getSession()->setFlash('success', 'Пакет успешно удален');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    protected function findModel($id)
    {
        if (($model = Credit_paket::findOne(['value'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
