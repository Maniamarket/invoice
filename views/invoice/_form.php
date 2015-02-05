<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Setting;
?>

<div class="form col-sm-5">

<?php $form = ActiveForm::begin([
	'id'=>'invoice-form',
	'enableAjaxValidation'=>false,
	'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-md-10\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div>",
    ],
]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


    <div class="form-group">
        <div class="col-sm-10">
            <?php  echo Html::label('Invoice ID',''); echo '  MM'.$model->id;  ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-10">
            <?php  echo Html::label('Date',''); echo '  '.$model->date;;  ?>
        </div>
    </div>

    <div class="form-group">
          <?php echo $form->field($model, 'company_id',['labelOptions'=>['class'=>'control-label col-md-2']])->dropDownList(app\models\Setting::List_company(),['prompt'=>'-Choose a Company-'])->hint('Company')->label('Company') ; ?>
        </div>
        <div class="form-group">
          <?php echo $form->field($model, 'client_id',['labelOptions'=>['class'=>'control-label col-md-2']])->dropDownList(app\models\Setting::List_client(),['prompt'=>'-Choose a Client-'])->hint('client')->label('client') ; ?>
        </div>

        <div class="form-group">
           <?php  echo Html::label('Service','');  ?> &nbsp;&nbsp;
          <?php  echo Html::dropDownList('service_id',0, Setting::List_service()) ; ?>
        </div>

    <div class="form-group">
        <?php  echo Html::label('Qty','');  ?> &nbsp;&nbsp;
        <?php echo Html::textInput('count','', []);
//             echo Html::error($model, 'count'); */
        ?>
    </div>

    <div class="form-group">
        <?php  echo Html::label('Unit Cost','');  ?> &nbsp;&nbsp;
        <?php echo Html::textInput('price_service','', []);
//             echo Html::error($model, 'price_service'); */
     ?>
    </div>

    <div class="form-group">
        <?php  echo Html::label('Discount','');  ?> &nbsp;&nbsp;
        <?php echo Html::textInput('discount','', []);
        //echo Html::error($model, 'vat'); */
        ?>
    </div>

    <div class="form-group">
        <?php  echo Html::label('Vat','');  ?> &nbsp;&nbsp;
        <?php echo Html::dropDownList('vat',$vat, Setting::List_Vat());
        //echo Html::error($model, 'vat'); */
        ?>
    </div>

    <div class="form-group">
        <?php  echo Html::label('Income','');  ?> &nbsp;&nbsp;
        <?php echo Html::dropDownList('income',$income_tax,Setting::List_Surtax());
        //echo Html::error($model, 'vat'); */
        ?>
    </div>

    <div class="form-group">
        <?php  echo Html::label('Total','');  ?> &nbsp;&nbsp;
        <?php echo 'total';
        //echo Html::error($model, 'vat'); */
        ?>
    </div>


    <div class="row buttons">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->
<?php  Yii::$app->view->registerJsFile('@web/js/invoice.js'); ?>