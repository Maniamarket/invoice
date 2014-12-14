<?php

namespace app\controllers;

use app\models\Lang;
use Yii;
use app\models\Translit;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TransitController implements the CRUD actions for Translit model.
 */
class TranslitController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Translit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Translit::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Translit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Translit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Translit();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Translit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Translit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Translit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Translit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Translit::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConvert()
    {
        $b = array(
            'Р°' => 'a', 'Р±' => 'b', 'РІ' => 'v',
            'Рі' => 'g', 'Рґ' => 'd', 'Рµ' => 'e',
            'С‘' => 'e', 'Р¶' => 'zh', 'Р·' => 'z',
            'Рё' => 'i', 'Р№' => 'y', 'Рє' => 'k',
            'Р»' => 'l', 'Рј' => 'm', 'РЅ' => 'n',
            'Рѕ' => 'o', 'Рї' => 'p', 'СЂ' => 'r',
            'СЃ' => 's', 'С‚' => 't', 'Сѓ' => 'u',
            'С„' => 'f', 'С…' => 'h', 'С†' => 'c',
            'С‡' => 'ch', 'С€' => 'sh', 'С‰' => 'sch',
            'СЊ' => '\'', 'С‹' => 'y', 'СЉ' => '\'',
            'СЌ' => 'e', 'СЋ' => 'yu', 'СЏ' => 'ya',

            'Рђ' => 'A', 'Р‘' => 'B', 'Р’' => 'V',
            'Р“' => 'G', 'Р”' => 'D', 'Р•' => 'E',
            'РЃ' => 'E', 'Р–' => 'Zh', 'Р—' => 'Z',
            'Р' => 'I', 'Р™' => 'Y', 'Рљ' => 'K',
            'Р›' => 'L', 'Рњ' => 'M', 'Рќ' => 'N',
            'Рћ' => 'O', 'Рџ' => 'P', 'Р ' => 'R',
            'РЎ' => 'S', 'Рў' => 'T', 'РЈ' => 'U',
            'Р¤' => 'F', 'РҐ' => 'H', 'Р¦' => 'C',
            'Р§' => 'Ch', 'РЁ' => 'Sh', 'Р©' => 'Sch',
            'Р¬' => '\'', 'Р«' => 'Y', 'РЄ' => '\'',
            'Р­' => 'E', 'Р®' => 'Yu', 'РЇ' => 'Ya'
        );
        if (Yii::$app->request->post('from_lang')&&Yii::$app->request->post('to_lang')) {
            $model = Translit::find()->where(['from_lang_id'=>Yii::$app->request->post('from_lang'),'to_lang_id'=>Yii::$app->request->post('to_lang')])->all();
            $array = ArrayHelper::map($model,'from_symbol','to_symbol');
            echo strtr(Yii::$app->request->post('word'), $array);
        }else {
            echo strtr(Yii::$app->request->post('word'), $b);
        }
    }
}
