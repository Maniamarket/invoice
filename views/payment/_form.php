<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\BaseHtml;

/* @var $this ServiceController */
/* @var $model Service */
/* @var $form CActiveForm */
?>


<div class="form label-left">
    <?php $form = ActiveForm::begin([
        'id'=>'payment-form',
        'enableAjaxValidation'=>false,
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-3\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
        ],
    ]); ?>

	<?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?= $form->field($model, 'name',['labelOptions'=>['class'=>'control-label col-md-2']])->textInput() ?>
	</div>

    <?php $data = unserialize($model->data); ?>

    <?php switch($model->id) {
        case 2: //paypal
            ?>
    <div class="row">
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'e-mail') ?></label>
                <div class="col-md-3">
                    <input name="data_array[email]" type="text" class="form-control" value="<?= (isset($data['email'])) ? $data['email'] : '' ?>">
                </div>
            </div>
    </div>
        <?php break;
     ?>

    <?php case 3: //bank
 //             var_dump($data); exit;
    if (!empty($data))
    foreach ($data as $key=>$bank)  {
    ?>
    <div class="fieldset-full-grey">
        <label>Bank <?= $key+1 ?></label>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'Bank Name') ?></label>
                <div class="col-md-3">
                    <input name="data_array[<?= $key ?>][bank_name]" type="text" class="form-control" value="<?= (isset($bank['bank_name'])) ? $bank['bank_name'] : '' ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'Bank Account') ?></label>
                <div class="col-md-3">
                    <input name="data_array[<?= $key ?>][bank_account]" type="text" class="form-control" value="<?= (isset($bank['bank_account'])) ? $bank['bank_account'] : '' ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'IBAN') ?></label>
                <div class="col-md-3">
                    <input name="data_array[<?= $key ?>][iban]" type="text" class="form-control" value="<?= (isset($bank['iban'])) ? $bank['iban'] : '' ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <label class="control-label col-md-2"><?php echo Yii::t('app', 'SWIFT') ?></label>
                <div class="col-md-3">
                    <input name="data_array[<?= $key ?>][swift]" type="text" class="form-control" value="<?= (isset($bank['swift'])) ? $bank['swift'] : '' ?>">
                </div>
            </div>
        </div>
     </div>
    <?php } ?>

    <?php break;
    default: break;
    } ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-yellow']); ?>
    </div>


    <?php  ActiveForm::end(); ?>

    <?php if ($model->id == 3) {

        $count_data = (!empty($data)) ? count($data) : 0;
    ?>
        <?php $form = ActiveForm::begin([
            'action' => ['addbank'],
            'id'=>'add-new-bank-form',
            'enableAjaxValidation'=>false,
            'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-md-3\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
            ],
        ]); ?>
        <label>Add new Bank</label>
        <div class="fieldset-full-grey">
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo Yii::t('app', 'Bank Name') ?></label>
                    <div class="col-md-3">
                        <input name="data_array[<?= $count_data ?>][bank_name]" type="text" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo Yii::t('app', 'Bank Account') ?></label>
                    <div class="col-md-3">
                        <input name="data_array[<?= $count_data ?>][bank_account]" type="text" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo Yii::t('app', 'IBAN') ?></label>
                    <div class="col-md-3">
                        <input name="data_array[<?= $count_data ?>][iban]" type="text" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-md-2"><?php echo Yii::t('app', 'SWIFT') ?></label>
                    <div class="col-md-3">
                        <input name="data_array[<?= $count_data ?>][swift]" type="text" class="form-control" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <?php echo Html::submitButton('Add New Bank',['class'=>'btn btn-action']); ?>
        </div>
        <?php  ActiveForm::end(); ?>
    <?php } ?>
</div>
