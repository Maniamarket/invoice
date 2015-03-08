<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Setting;
use yii\helpers\Url;

 $_name = '{';
 foreach ( Setting::List_company() as $key=>$val) $_name .= $key.':"'.$val.'",';
$_name = ( $_name == '{' ) ? '{}' : substr($_name, 0,-1).'}';

//var_dump($_name); exit;

?>
<script type="text/javascript">
    var name = <?php echo $_name; ?>;
    var mac_name;
    if( name ) mac_name = name.split(':');
    else mac_name = 0;
/*    for (var key in name) {
        	    alert(key+':'+name[key])
        	}*/
//    alert(name[1]);
/*        jQuery(document).ready(function(){
$("#address-country_id").change( function(){
jQuery.get( '<?php //echo $url_region.'?id='; ?>'+jQuery('#address-country_id :selected').val() ,
function( data ) {
jQuery("#state").replaceWith(data);
}
);
});
});*/
</script>
<div class="form">

<?php
  $url = ( $is_add ) ? Url::toRoute(['invoice/create','create_invoice'=>(Yii::$app->session['create_invoice']+1)]) :
      Url::toRoute(['invoice/update','id'=>$model->id, 'create_invoice'=>(Yii::$app->session['create_invoice']+1)]);

    $form = ActiveForm::begin([
    'id'=>'invoice-form',
    'action'=> $url,
	'enableAjaxValidation'=>false,
	'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal', 'role'=>'form'],
    'fieldConfig' => [
        'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
    ],
]); ?>

	<div class="alert-danger"></duv><?php echo $form->errorSummary($model); ?></div>
    <div class="fieldset-column">
        <?php  echo Html::hiddenInput('id',$model->id);  ?>
        <div class="form-group field-invoice-id-display">
            <label class="control-label col-md-3" for="invoice-id-display"><?= Yii::t('app', 'Invoice ID') ?></label>
            <div class="col-md-6"><input id="invoice-id-display" class="form-control" value="<?= '  MM100'.$model->id; ?>" disabled="disabled" type="text"></div>
            <div class="col-md-offset-2 col-md-6"><p class="help-block help-block-error"></p></div>
        </div>
        <?php echo $form->field($model, 'date',['labelOptions'=>['class'=>'control-label col-md-3']])->textInput(['disabled'=>'disabled']) ; ?>
        <?php /*echo $form->field($model, 'company_id',['labelOptions'=>['class'=>'control-label col-md-3'],
            'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
        ])->dropDownList(Setting::List_company(),['prompt'=>'-Choose a Company-','id'=>'list_company']); */
        ?>

        <?php
          $url_company = Url::toRoute(['invoice/ajax_company']);
            echo $form->field($model, 'company_id',['labelOptions'=>['class'=>'control-label col-md-3'],
                'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
            ])->dropDownList(Setting::List_company(),['class'=>'dropdown-ajax','id'=>'company_name','data-url'=>$url_company]);
//          echo Html::textInput('input_company','',['id'=>'company_name', 'onkeyup'=>'list_company_ajax("'.$url_company.'")']);
        ?>

        <?php
          $url_client = Url::toRoute(['invoice/ajax_client']);
           echo $form->field($model, 'client_id',['labelOptions'=>['class'=>'control-label col-md-3'],
            'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
        ])->dropDownList(Setting::List_client(),['class'=>'dropdown-ajax','id'=>'client_name','data-url'=>$url_client]); ?>

        <?php echo $form->field($model, 'payment_id',['labelOptions'=>['class'=>'control-label col-md-3'],
            'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
        ])->dropDownList(Setting::List_payment(),['prompt'=>'-Choose a Payment-']); ?>
        <?php echo $form->field($model, 'type',['labelOptions'=>['class'=>'control-label col-md-3'],
            'template' => "{label}\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
        ])->dropDownList(Setting::List_templates(),['prompt'=>'-Choose a Template-']); ?>
    </div>

    <table class="invoice-service-items">
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
                 <td colspan="4" class="separator">
                     <div class="fieldset-column">
                         <div class="form-group">
                             <?php  echo Html::label(Yii::t('app','Service'),'',['class'=>'control-label col-md-3']);  ?>
                             <div class="col-md-8">
                                 <?php  echo Html::dropDownList('items['.$key.'][service_id]',$item['service_id'], Setting::List_service(),['class'=>'form-control']) ; ?>
                             <div class="col-md-offset-2 col-md-6"><p class="help-block help-block-error"></p></div>
                         </div>
                     </div>
                 </td>
             </tr>
             <tr>
                 <td class="qty">   <?php  echo Html::label(Yii::t('invoice','Qty'),'');  ?>           </td>
                 <td class="unit-cost">   <?php  echo Html::label(Yii::t('invoice','Unit Cost').', &euro;','');  ?>     </td>
                 <td class="discount">   <?php  echo Html::label(Yii::t('invoice','Discount').', %','');  ?>      </td>
                 <td class="total">   <?php echo Html::label(Yii::t('invoice','Total'),'')  ?>           </td>
             </tr>
             <tr>
                 <td class="qty" id="item_<?php echo($qty);?>" >
                     <?php echo Html::textInput('items['.$key.'][count]',$item['count'], ['id'=>$qty,'class'=>"invoice-item form-control"]);
                     ?>
                 </td>

                 <td class="unit-cost" id="item_<?php echo($price);?>" >
                     <?php echo Html::textInput('items['.$key.'][price_service]',$item['price_service'], ['id'=>$price,'class'=>"invoice-item form-control"]);
                     ?>
                 </td>

                 <td class="discount" id="item_<?php echo($discount);?>" >
                     <?php echo Html::textInput('items['.$key.'][discount]',$item['discount'], ['id'=>$discount,'class'=>"invoice-item form-control"]);
                     ?>
                 </td>

                 <td class="total" id="item_<?php echo($total);?>" >
                     <?php //echo Html::label($item['total_price'],'', ['id'=>$total])
                     echo Html::textInput('total_price',$item['total_price'], ['id'=>$total,'class'=>"invoice-item form-control",'disabled'=>"disabled"]);
                     ?>
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
       <?php }  if( $is_add ) { ?>

        <tr>
            <td colspan="4" class="separator">
                <div class="fieldset-column">
                    <div class="form-group">
                        <?php  echo Html::label(Yii::t('app','Service'),'',['class'=>'control-label col-md-3']);  ?>
                        <div class="col-md-8">
                            <?php  echo Html::dropDownList('service_id',0, Setting::List_service(),['class'=>'form-control']) ; ?>
                            <div class="col-md-offset-2 col-md-6"><p class="help-block help-block-error"></p></div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td class="qty">  <?php  echo Html::label(Yii::t('invoice','Qty'),'');  ?> </td>
            <td class="unit-cost">  <?php  echo Html::label(Yii::t('invoice','Unit Cost').', &euro;','');  ?>  </td>
            <td class="discount">  <?php  echo Html::label(Yii::t('invoice','Discount').', %','');  ?>   </td>
            <td class="total">  <?php echo Html::label(Yii::t('invoice','Total'),'')  ?>        </td>
        </tr>
        <tr>
            <td class="qty" id="item_qty" >
                <?php echo Html::textInput('count',(($model_item) ? $model_item->count : 1), ['id'=>"qty_",'class'=>"invoice-item form-control"]); ?>
            </td>

            <td class="unit-cost" id="item_price" >
                <?php echo Html::textInput('price_service',(($model_item) ? $model_item->price_service : 0), ['id'=>"price_",'class'=>"invoice-item form-control"]);
                ?>
            </td>

            <td  class="discount" id="item_discount" >
                <?php echo Html::textInput('discount',(($model_item) ? $model_item->discount : 0), ['id'=>"discount_",'class'=>"invoice-item form-control"]);
                ?>
            </td>

            <td class="total" id="item_total" >
                <?php //echo Html::label((($model_item) ? $model_item->total_price : ''),'', ['id'=>"total_"])
                echo Html::textInput('total_price',(($model_item) ? $model_item->total_price : ''), ['id'=>"total_",'class'=>"invoice-item form-control",'disabled'=>"disabled"]);
                ?>
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
       <?php }  ?>
    </table>
    <div class="row buttons">
        <?php  echo Html::submitButton('+ Add New service',['class'=>'btn btn-grey','name'=>'submit','value'=>'add']); ?>
    </div>


    <div class="invoice-tax">
        <table class="table table-bordered table-align-left">
            <tr>
                <td style="width: 200px;"> Net Price </td>
                <td style="width: 80px;">  <?php echo Html::label( $itog['net'],'', ['id'=>"net_itog"]); ?>  </td>
            </tr>
            <tr>
                <td><nobr>
                    <?php echo $form->field($model, 'vat_id',['labelOptions'=>['class'=>'control-label col-md-6'],
                        'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-md-8\">{error}</div>"
                    ])->dropDownList( Setting::List_Vat(),['id'=>'vat', 'class'=>'form-control',
//                            'onchange'=>'set_itog("'.$is_add.'","'.$count_items.'","'.$model->income.'")'])->label(false);
                    'onchange'=>'set_itog()'])->label('Tax Vat%',['style'=>'padding-left: 0; text-align: left;']);
                    ?></nobr>
                </td>
                <td>  <?php echo Html::label( $itog['vat'],'', ['id'=>"net_vat"]); ?>  </td>
            </tr>
            <tr>
                <td> Income Tax% -
                    <?php echo Html::label( $model->income,'');?>
                </td>
                <td><?php echo Html::label( $itog['income'],'', ['id'=>"net_income"]); ?></td>
            </tr>
            <tr>
                <td> Grand Total </td>
                <td> <?php echo Html::label( $itog['total'],'', ['id'=>"total_itog"]); ?> </td>
            </tr>
        </table>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <?php echo $form->field($model, 'notes',[
            'template' => "<div class=\"col-md-10\">{label}\n</div><div class=\"col-md-12\">{input}</div>\n<div class=\"col-md-offset-2 col-md-6\">{error}</div>",
        ])->textarea(['style'=>'min-height:200px;']); ?>
    </div>

    <div class="row buttons pull-right" >
        <?php echo Html::submitButton('Submit' ,['class'=>'btn btn-yellow','name'=>'submit','value'=>'end']); ?>
        <?php echo Html::submitButton('Clear' ,['class'=>'btn btn-action','name'=>'submit','value'=>'cleare']); ?>
	</div>

    <?php ActiveForm::end(); ?>

</div><!-- form -->
<?php
/** @var \yii\data\ActiveDataProvider $dataProvider */
Yii::$app->view->registerJsFile('@web/js/invoice_form.js');
?>

<script type="text/javascript">
    function total_price(elem){
        var a = $(elem).attr('id');
        var mas = a.split('_');
        var id = '';
        var income = <?php echo  $model->income ?> ;
        var vat = $('#vat :selected').text();

        if( mas.length > 1 ) id = mas[1];
        a = id.toString();
        var count = $('#qty_'+a).val();
        var price = $('#price_'+a).val();
        var discount = $('#discount_'+a).val();
        var net = parseFloat(price*count)*(1-parseFloat(discount)/100);
        var total = 0;
//        var total = net*(1-parseFloat(discount)/100)*(1+(parseFloat(vat)+parseFloat(income))/100);
//            alert(total+' vat '+vat+' net '+net+ ' income '+income+' discount '+discount+' count= '+count+' prise= '+price);
        $('#total_'+a).val(net);

        var count_items =  <?php echo ($count_items) ? $count_items : 0; ?> ;
        var is_add = <?php echo ($is_add) ? 1 : 0; ?>;
        var net_itog = 0;
            if(  is_add  ){
                count = $('#qty_').val();
                price = $('#price_').val();
                discount = $('#discount_').val();
                net = parseFloat(price*count);
                net_itog = net*(1-parseFloat(discount)/100);
            }
            for( var i=1; i<= count_items; i++){
                var to = (i-1).toString();
                count = $('#qty_'+ to).val();
                price = $('#price_'+to).val();
                discount = $('#discount_'+to).val();
                net = parseFloat(price*count);
                net_itog = net_itog + net*(1-parseFloat(discount)/100);
            }
        net_itog = net_itog.toFixed(2);
        var vat_cost = net_itog*parseFloat(vat)/100;
        vat_cost = vat_cost.toFixed(2);
        var income_cost = net_itog*parseFloat(income)/100;
        income_cost = income_cost.toFixed(2);
        total = parseFloat(net_itog) + parseFloat(vat_cost);
        total = total.toFixed(2);
    // alert(total);
        $('#net_income').text(income_cost);
        $('#net_vat').text(vat_cost);
        $('#net_itog').text(net_itog);
        $('#total_itog').text(total);
        return false;
    }
    $(document).on('change', '.invoice-item', function (){
            return total_price(this);
        }
    );

</script>