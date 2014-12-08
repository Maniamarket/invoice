<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\helpers\BaseHtml;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
function getValue($json)
{
	
}
</script>

<div class='invoice-form'>

    <?php $form = ActiveForm::begin(); ?>
	<p>
		<?= Html::label(Yii::t('app','Invoice').':') ?>
		<?= Html::activeTextInput($model, 'number', ['class'=>'input-control']) ?>
		<?= Html::label(Yii::t('app','From').':') ?>
		<?= Html::activeTextInput($model, 'date', ['value' => date('d.m.y'),'class'=>'input-control']) ?>
	</p>
	<p>
		<?php $jsonAddrList = json_encode($sellersAddrList) ?>
		<?php $jsonInnList = json_encode($sellersInnList) ?>
		<?= Html::label(Yii::t('app','Seller').':'); ?>
		<?= Html::activeDropDownList($model, 'seller_id', $sellersList, [
											'id'=>'seller_selector',
											'prompt'=>'Choose a Company',
											'class'=>'input-control',
											'onchange'=>'getSellerAddr('.$jsonAddrList.'); getSellerInn('.$jsonInnList.')',
											]) ?>
	</p>
	<p>
		<?= Html::label(Yii::t('app','Address').':') ?>
		<?= Html::label('', '', ['id'=>'seller_addr']) ?>
	</p>
	<p>
		<?= Html::label(Yii::t('app','INN').':') ?>
		<?= Html::label('', '', ['id'=>'seller_inn']) ?>
	</p>
	<p>
		<?= Html::label(Yii::t('app','Sender address').':') ?>
		<?= Html::activeTextInput($model, 'sender_addr', ['id'=>'sender_addr','class'=>'input-control','size'=>64]) ?>
	</p>
	<p>
		<?= Html::label(Yii::t('app','Recipient address').':') ?>
		<?= Html::activeTextInput($model, 'recipient_addr', ['id'=>'recipient_addr','class'=>'input-control','size'=>64]) ?>
	</p>
	<p>
		<?= Html::activeTextInput($model, 'bill_number', ['class'=>'input-control','size'=>6]) ?>
	</p>
	<p>
		<?= Html::label(Yii::t('app', Yii::t('app','Client')).':'); ?>
		<?php $jsonAddrList = json_encode($clientsAddrList) ?>
		<?php $jsonInnList = json_encode($clientsInnList) ?>
		<?= Html::activeDropDownList($model, 'client_id', $clientsList, [
											'id'=>'client_selector',
											'prompt'=>'Choose a Company',
											'class'=>'input-control',
											'onchange'=>'getClientAddr('.$jsonAddrList.'); getClientInn('.$jsonInnList.')',
											]) ?>
	</p>
	<p>
		<?= Html::label(Yii::t('app','Address').':') ?>
		<?= Html::label('', '', ['id'=>'client_addr']) ?>
	</p>
	<p>
		<?= Html::label(Yii::t('app','INN').':') ?>
		<?= Html::label('', '', ['id'=>'client_inn']) ?>
	</p>

    <?= $form->field($model, 'currency_id')->textInput() ?>

    <div class='form-group'>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
function getSellerAddr(json)
{
	var obj = document.getElementById('seller_selector');
	var key = obj.options[obj.selectedIndex].value;
	document.getElementById('seller_addr').innerHTML = json[key];
	document.getElementById('sender_addr').value = json[key];
}
function getSellerInn(json)
{
	var obj = document.getElementById('seller_selector');
	var key = obj.options[obj.selectedIndex].value;
	document.getElementById('seller_inn').innerHTML = json[key];
}
function getClientAddr(json)
{
	var obj = document.getElementById('client_selector');
	var key = obj.options[obj.selectedIndex].value;
	document.getElementById('client_addr').innerHTML = json[key];
	document.getElementById('recipient_addr').value = json[key];
}
function getClientInn(json)
{
	var obj = document.getElementById('client_selector');
	var key = obj.options[obj.selectedIndex].value;
	document.getElementById('client_inn').innerHTML = json[key];
}
</script>
