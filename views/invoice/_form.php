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
             $qty = 'qty_'.$key;
             $price = 'price_'.$key;
             $discount = 'discount_'.$key;
             $total = 'total_'.$key;
             $error = ( isset($items_error[$key])) ? $items_error[$key] : [];

           echo Html::hiddenInput('items['.$key.'][id]',$item['id']);
       ?>
             <tr>
                 <td colspan="4">
                     <div class="form-group">
                         <?php  echo Html::label('Service','');  ?>
                         <?php  echo Html::dropDownList('items['.$key.'][service_id]',$item['service_id'], Setting::List_service()) ; ?>
                     </div>
                 </td>
             </tr>
             <tr>
                 <td>   <?php  echo Html::label('Qty','');  ?>           </td>
                 <td>   <?php  echo Html::label('Unit Cost','');  ?>     </td>
                 <td>   <?php  echo Html::label('Discount','');  ?>      </td>
                 <td>   <?php echo Html::label('Total','')  ?>           </td>
             </tr>
             <tr>
                 <td id="item_<?php echo($qty);?>" >
                     <?php echo Html::textInput('items['.$key.'][count]',$item['count'], ['id'=>$qty,'class'=>"invoice-item"]);
                     ?>
                 </td>

                 <td id="item_<?php echo($price);?>" >
                     <?php echo Html::textInput('items['.$key.'][price]',$item['price_service'], ['id'=>$price,'class'=>"invoice-item"]);
                     ?>
                 </td>

                 <td id="item_<?php echo($discount);?>" >
                     <?php echo Html::textInput('items['.$key.'][discount]',$item['discount'], ['id'=>$discount,'class'=>"invoice-item"]);
                     ?>
                 </td>

                 <td id="item_<?php echo($total);?>" >
                     <?php echo Html::label($item['total_price'],'', ['id'=>$total])  ?>
                 </td>
             </tr>
             <tr>
                 <td>
                   <?php  echo Html::label(isset($error['count']) ? $error['count'][0] : '','',['style'=>'color : red']);  ?>
                 </td>

                 <td>
                   <?php  echo Html::label(isset($error['price_service']) ? $error['price_service'][0] : '','',['style'=>'color : red']);?>
                 </td>

                 <td>
                 <?php echo Html::label( isset($error['discount']) ? $error['discount'][0] : '','',['style'=>'color : red']);  ?>
                 </td>

                 <td></td>
             </tr>
       <?php } ?>

        <tr>
            <td colspan="4">
                <div class="form-group">
                    <?php  echo Html::label('Service','');  ?> &nbsp;&nbsp;
                    <?php  echo Html::dropDownList('service_id',0, Setting::List_service()) ; ?>
                </div>
            </td>
        </tr>

        <tr>
            <td>  <?php  echo Html::label('Qty','');  ?> </td>
            <td>  <?php  echo Html::label('Unit Cost','');  ?>  </td>
            <td>  <?php  echo Html::label('Discount','');  ?>   </td>
            <td>  <?php echo Html::label('Total','')  ?>        </td>
        </tr>
        <tr>
            <td id="item_qty" >
                <?php echo Html::textInput('count',(($model_item) ? $model_item->count : ''), ['id'=>"qty_",'class'=>"invoice-item"]); ?>
            </td>

            <td id="item_price" >
                <?php echo Html::textInput('price_service',(($model_item) ? $model_item->price_service : ''), ['id'=>"price_",'class'=>"invoice-item"]);
                ?>
            </td>

            <td id="item_discount" >
                <?php echo Html::textInput('discount',(($model_item) ? $model_item->discount : ''), ['id'=>"discount_",'class'=>"invoice-item"]);
                ?>
            </td>

            <td id="item_total" >
                <?php echo Html::label((($model_item) ? $model_item->total_price : ''),'', ['id'=>"total_"])  ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo Html::label(isset($model_item->errors['count']) ? $model_item->errors['count'][0] : '','',['style'=>'color : red']); ?>
            </td>

            <td>
                <?php echo Html::label(isset($model_item->errors['price_service']) ? $model_item->errors['price_service'][0] : '','',['style'=>'color : red']); ?>
            </td>

            <td>
            <?php  echo Html::label(isset($model_item->errors['discount']) ? $model_item->errors['discount'][0] : '','',['style'=>'color : red']); ?>
            </td>

            <td></td>
        </tr>
    </table>
    <div class="row buttons">
        <?php if( $is_add ) echo Html::submitButton('Add New service',['class'=>'btn btn-success','name'=>'submit','value'=>'add']); ?>
    </div>


    <div class="form-group" style="position: relative; right: 1px">
        <table style="border: 1px solid #000000">
            <thead><th></th><th></th></thead>
            <tr style="border: 1px solid #000000">
                <td> Net Price </td>
                <td>  <?php echo Html::label( $itog['net'],'', ['id'=>"net_itog"]); ?>  </td>
            </tr>
            <tr  style="border: 1px solid #000000">
                <td style="border: 1px solid #000000"> Vat </td>
                <td style="border: 1px solid #000000"> <?php echo $form->field($model, 'vat_id',[])->dropDownList( Setting::List_Vat(),['id'=>'vat'])->label(false); ?> </td>
            </tr>
            <tr  style="border: 1px solid #000000">
                <td style="border: 1px solid #000000"> Income Tax </td>
                <td style="border: 1px solid #000000"> <?php echo Html::label( $model->income,'');?> </td>
            </tr>
            <tr  style="border: 1px solid #000000">
                <td style="border: 1px solid #000000"> Grand Total </td>
                <td style="border: 1px solid #000000"> <?php echo Html::label( $itog['total'],'', ['id'=>"total_itog"]); ?> </td>
            </tr>
        </table>
    </div>

    <div class="clearfix"></div>

    <div class="row buttons" style="position: absolute; right: 1px" >
        <?php echo Html::submitButton('Submit' ,['class'=>'btn btn-success','name'=>'submit','value'=>'end']); ?>
        <?php echo Html::submitButton('Clear' ,['class'=>'btn btn-success','name'=>'submit','value'=>'cleare']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->
<script type="text/javascript">
    function total_price(elem){
        var a = $(elem).attr('id');
        var mas = a.split('_');
        var id = '';
        var income = <?php echo  $model->income ?> ;
        var vat = $('#vat :selected').text();;

        if( mas.length > 1 ) id = mas[1];
        a = id.toString();
        var count = $('#qty_'+a).val();
        var price = $('#price_'+a).val();
        var discount = $('#discount_'+a).val();
        var net = parseFloat(price*count);
        var total = net*(1+(parseFloat(vat)+parseFloat(income)-parseFloat(discount))/100);
        //    alert(total+' vat '+vat+' net '+net+ ' income '+income+' discount '+discount+' count= '+count+' prise= '+price);
        $('#total_'+a).text(total);

        var count_items =  <?php echo $count_items ?> ;
        if( count_items ){
            if( mas.length >1 ){
                count = $('#qty_').val();
                price = $('#price_').val();
                discount = $('#discount_').val();
                net = parseFloat(price*count);
                total = net*(1+(parseFloat(vat)+parseFloat(income)-parseFloat(discount))/100);
            }
            var net_itog = net;
            for( var i=1; i<= count_items; i++){
                var to = (i-1).toString();
                count = $('#qty_'+ to).val();
                price = $('#price_'+to).val();
                discount = $('#discount_'+to).val();
                net = parseFloat(price*count);
                net_itog = net_itog + net;
                total = total+net*(1+(parseFloat(vat)+parseFloat(income)-parseFloat(discount))/100);
            }
            net_itog = net_itog.toFixed(2);
            total = total.toFixed(2);
            $('#net_itog').text(net_itog);
            $('#total_itog').text(total);
        }
        return false;
    }
    $(document).on('change', '.invoice-item', function (){
            return total_price(this);
        }
    );

</script>