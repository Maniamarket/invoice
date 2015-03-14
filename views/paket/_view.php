<?php
use yii\helpers\Html;
use yii\helpers\Url;

$view_element = 'paket_id'.$model->value;
?>

<tr id="<?php echo Html::encode($view_element); ?>">
    <td><?php echo Html::encode($model->value); ?></td>
    <td><?php echo Html::encode($model->price); ?></td>
    <td>
       <?php 
            echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                    ['update', 'id'=>$model->value],['title'=>'Update']);
       ?>
      &nbsp;
      <?php  $url = Url::toRoute(['paket/delete','id'=>$model->value]);
           echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',$url,
           [
             'title' => Yii::t('yii', 'Delete'),
             'onclick'=>"if(confirm('Вы действительно хотите удалить?'))"
            . "{ $('#".$view_element." ').dialog('open');//for jui dialog in my page
                $.ajax({
               type     :'POST',
               cache    : false,
               url  : '.$url.',
               success  : function(response) { $('#".$view_element."').html(response);   }
           })}; return false; ",
          ]);
      ?> 
   </td>
</tr>