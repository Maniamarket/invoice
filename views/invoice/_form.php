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
            <?php  echo Html::hiddenInput('id',$model->id);  ?>
    </div>

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
          <?php echo $form->field($model, 'company_id',['labelOptions'=>['class'=>'control-label col-md-2']])->dropDownList(Setting::List_company(),['prompt'=>'-Choose a Company-'])->hint('Company')->label('Company') ; ?>
    </div>

    <div class="form-group">
      <?php echo $form->field($model, 'client_id',['labelOptions'=>['class'=>'control-label col-md-2']])->dropDownList(app\models\Setting::List_client(),['prompt'=>'-Choose a Client-'])->hint('client')->label('client') ; ?>
    </div>

    <table>
       <?php
         $count_items = count($items);
         if( $count_items ) foreach( $items as $key=>$item ){
             $qty = 'qty'.$key;
             $price = 'price'.$key;
             $discount = 'discount'.$key;
             $total = 'total'.$key;
             $error = ( isset($items_error[$key])) ? $items_error[$key] : [];

           echo Html::hiddenInput('items['.$key.'][id]',$item['id']);
       ?>
             <tr>
                 <td>
                     <div class="form-group">
                         <?php  echo Html::label('Service','');  ?>
                         <?php  echo Html::dropDownList('items['.$key.'][service_id]',$item['service_id'], Setting::List_service()) ; ?>
                     </div>
                 </td>
             </tr>
             <tr>
                 <td>
                     <?php  echo Html::label('Qty','');  ?>
                 </td>
                 <td>
                     <?php  echo Html::label('Unit Cost','');  ?>
                 </td>
                 <td>
                     <?php  echo Html::label('Discount','');  ?>
                 </td>
                 <td>
                     <?php echo Html::label('Total','')  ?>
                 </td>
             </tr>
           <tr>
               <td id="item_<?php echo($qty);?>"  class="invoice-item">
                   <?php echo Html::textInput('items['.$key.'][count]',$item['count'], ['id'=>$qty]);
                         echo Html::label(isset($error['count']) ? $error['count'][0] : '','',['style'=>'color : red']);
                   ?>
               </td>

               <td id="item_<?php echo($price);?>"  class="invoice-item">
                   <?php echo Html::textInput('items['.$key.'][price]',$item['price_service'], ['id'=>$price]);
                         echo Html::label(isset($error['price_service']) ? $error['price_service'][0] : '','',['style'=>'color : red']);
                   ?>
               </td>

               <td id="item_<?php echo($discount);?>"  class="invoice-item">
                   <?php echo Html::textInput('items['.$key.'][discount]',$item['discount'], ['id'=>$discount]);
                         echo Html::label( isset($error['discount']) ? $error['discount'][0] : '','',['style'=>'color : red']);
                   ?>
               </td>

               <td id="item_<?php echo($total);?>"  class="invoice-item">
                   <?php echo Html::label($item['total_price'],'', ['id'=>$total])  ?>
               </td>
           </tr>
       <?php } ?>

        <tr>
            <td>
                <div class="form-group">
                    <?php  echo Html::label('Service','');  ?> &nbsp;&nbsp;
                    <?php  echo Html::dropDownList('service_id',0, Setting::List_service()) ; ?>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <?php  echo Html::label('Qty','');  ?>
            </td>

            <td>  <?php  echo Html::label('Unit Cost','');  ?>  </td>

            <td>
                <?php  echo Html::label('Discount','');  ?>
            </td>

            <td>
                <?php echo Html::label('Total','')  ?>
            </td>
        </tr>
        <tr>
            <td id="item_qty"  class="invoice-item">
                <?php echo Html::textInput('count',(($model_item) ? $model_item->count : ''), ['id'=>"qty"]);
                  echo Html::label(isset($model_item->errors['count']) ? $model_item->errors['count'][0] : '','',['style'=>'color : red']);
                ?>
            </td>

            <td id="item_price"  class="invoice-item">
                <?php echo Html::textInput('price_service',(($model_item) ? $model_item->price_service : ''), ['id'=>"price"]);
                echo Html::label(isset($model_item->errors['price_service']) ? $model_item->errors['price_service'][0] : '','',['style'=>'color : red']);
                ?>
            </td>

            <td id="item_discount"  class="invoice-item">
                <?php echo Html::textInput('discount',(($model_item) ? $model_item->discount : ''), ['id'=>"discount"]);
                echo Html::label(isset($model_item->errors['discount']) ? $model_item->errors['discount'][0] : '','',['style'=>'color : red']);
                ?>
            </td>

            <td id="item_total"  class="invoice-item">
                <?php echo Html::label((($model_item) ? $model_item->total_price : ''),'')  ?>
            </td>
        </tr>


    </table>
    <div class="row buttons">
        <?php if( $is_add ) echo Html::submitButton('Add New service',['class'=>'btn btn-success','name'=>'submit','value'=>'add']); ?>
    </div>



    <div class="form-group">
        <?php echo $form->field($model, 'vat_id',['labelOptions'=>['class'=>'control-label col-md-2']])->dropDownList( Setting::List_Vat(),[])->label('Vat') ; ?>
    </div>

    <div class="form-group">
        <?php echo 'Income tax  '.$model->income;
        //echo $form->field($model,'income',['labelOptions'=>['class'=>'control-label col-md-2']])->dropDownList( Setting::List_Surtax(),[])->label('Income tax') ; ?>
        ?>
    </div>

    <div class="row buttons">
		<?php echo Html::submitButton($is_add ? 'Create' : 'Save',['class'=>'btn btn-success','name'=>'submit','value'=>'end']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->
<?php  Yii::$app->view->registerJsFile('@web/js/invoice.js'); ?>