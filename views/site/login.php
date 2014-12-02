<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title=Yii::$app->name . ' - Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="info">        
        <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

<h1><?php echo Yii::t('lang', 'LoginHeaderText'); ?></h1>

<p><?php echo Yii::t('lang', 'LoginBodyText'); ?></p>

<div class="form">
<?php $form = ActiveForm::begin([
	'id'=>'login-form',
	'enableClientValidation'=>true,
/*	'clientOptions'=>[
		'validateOnSubmit'=>true,
	],*/
]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
        <?= $form->field($model, 'username') ?>
	</div>

	<div class="row">
        <?= $form->field($model, 'password')->passwordInput() ?>

	</div>

	<div class="row rememberMe">
        <?= $form->field($model, 'rememberMe', [
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ])->checkbox() ?>
	</div>

	<div class="row buttons">
		<?php echo Html::submitButton('Login'); ?>
	</div>
	<div class="row rememberMe">	   
	    <?php echo Html::a('New user register','index.php/site/register'); ?>
	</div>

<?php ActiveForm::end(); ?>
</div><!-- form -->
