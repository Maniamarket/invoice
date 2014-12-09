<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


$this->title = Yii::$app->name . ' - Buy';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?php  echo 'System payment';  ?></h1>
<h3>Выберите платежную систему</h3>
<?php echo Html::beginForm(['user/buy','id'=>  Yii::$app->user->id]); ?>
<?php echo Html::radioList('payment',[],  \app\models\Setting::List_payment(),['separator'=>'<br />']); ?>
<?php// echo Html::radioList('payment',[],[1=>'PayPal',2=>'Bank Card', 3=>'Bank transfer'],['separator'=>'<br />']); ?>
<?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'send']) ?>
<?php echo Html::endForm(); ?>
