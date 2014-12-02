<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form = ActiveForm::begin([
	'id'=>'company-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
 /*   'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],*/
//	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
      <?php
        echo $form->field($model, 'name', [
        'inputOptions' => [
        'placeholder' => $model->getAttributeLabel('name'),
        ],
        ])->label(false);
      ?>
	</div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'logo', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('logo'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'country', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('country'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'city', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('city'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'street', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('street'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'post_index', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('post_index'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'phone', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('phone'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'web_site', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('web_site'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'mail', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('mail'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'vat_number', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('vat_number'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'activity', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('activity'),
            ],
        ])->label(false);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'resp_person', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('resp_person'),
            ],
        ])->label(false);
        ?>
    </div>

	<div class="row buttons">
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->