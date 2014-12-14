<?php
use yii\helpers\Html;
use yii\helpers\Url;

$view_element = 'tax_id'.$model->id;
$view_element_td = 'td_tax_id'.$model->id;
?>

<tr id="<?php echo Html::encode($view_element); ?>">
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::textInput('percent', $model->percent, ['id'=>$view_element_td]); ?></td>
    <td>
       <?php 
            $url = Url::toRoute(['tax/update','id'=>$model->id]);
            echo Html::a('save',Url::toRoute(['tax/update','id'=>$model->id]),
            [
             'title' => Yii::t('yii', 'Save'),
             'class' => 'btn btn-primary btn-xs',
             'onclick'=>"{  var percent = $('#".$view_element_td." ').val();
               $.ajax({
               url  : '".$url."',
               type :'POST',
               data: {'percent': percent},
               success  : function(response) { $('#".$view_element_td."').empty().html(response).focus();   }
             })}; return false; ",
           ]);
       ?>
      &nbsp;
      <?php  
           echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',['delete', 'id'=>$model->id],
           [
             'title' => Yii::t('yii', 'Delete'),
             'onclick'=>"if(confirm('Р’С‹ РґРµР№СЃС‚РІРёС‚РµР»СЊРЅРѕ С…РѕС‚РёС‚Рµ СѓРґР°Р»РёС‚СЊ?'))"
            . "{ $('#".$view_element." ').dialog('open');//for jui dialog in my page
                $.ajax({
               type     :'POST',
               cache    : false,
               url  : 'tax/delete',
               success  : function(response) { $('#".$view_element."').html(response);   }
           })}; return false; ",
          ]);
      ?> 
   </td>
</tr>