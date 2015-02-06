<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Lang;
use app\models\Country;
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */
?>

<div class="form col-sm-5">

<?php $form = ActiveForm::begin([
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
/*    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],*/
	'options'=>['enctype'=>'multipart/form-data', 'role'=>'form'],
]); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
        <?= $form->field($model, 'name') ?>
	</div>
    <div class="form-group">
        <label>Логотип</label>
        <?php echo Html::activeFileInput($model,'file') ?>
    </div>
    <div class="form-group">
        <?php
        echo $form->field($model, 'country_id',[ 'inputOptions' => [ 'placeholder' => $model->getAttributeLabel('country'),
                'class' => 'form-control',
            ], ])->dropDownList( Country::list_Countries(Lang::$current->id))->label(false) ; 
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
        echo $form->field($model, 'fax', [
            'inputOptions' => [
                'placeholder' => $model->getAttributeLabel('fax'),
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
		<?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Save',['class'=>'btn btn-success']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->