<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td>
       <?php  echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
            ['update', 'id'=>$model->id],['title'=>'Update']); 
       ?>
      &nbsp;
      <?php  
        echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
            ['delete', 'id'=>$model->id],['title'=>'Delete', 'onclick'=>'return confirm("Вы действительно хотите удалить?");']); 
      ?> 
   </td>
</tr>