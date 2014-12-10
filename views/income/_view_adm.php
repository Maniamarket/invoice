<?php
use yii\helpers\Html;
use yii\helpers\Url;

$view_element = 'income_id'.$model->id;
$view_element_td = 'td_income_id'.$model->id;
?>

<tr id="<?php echo Html::encode($view_element); ?>">
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->from); ?></td>
    <td><?php echo Html::encode($model->to); ?></td>
    <td><?php echo Html::encode($model->manager); ?></td>
    <td><?php echo Html::encode($model->admin); ?></td>
    <td>
       <?php 
            echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                    ['update', 'id'=>$model->id],['title'=>'Update']);
       ?>
      &nbsp;
      <?php  
           echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',['delete', 'id'=>$model->id],
           [
             'title' => Yii::t('yii', 'Delete'),
             'onclick'=>"if(confirm('Вы действительно хотите удалить?'))"
            . "{ $('#".$view_element." ').dialog('open');//for jui dialog in my page
                $.ajax({
               type     :'POST',
               cache    : false,
               url  : 'income/delete',
               success  : function(response) { $('#".$view_element."').html(response);   }
           })}; return false; ",
          ]);
      ?> 
   </td>
</tr>