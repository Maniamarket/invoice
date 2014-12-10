<?php
use yii\helpers\Html;
use yii\helpers\Url;

$view_element = 'lang_id'.$model->id;
?>

<tr id="<?php echo Html::encode($view_element); ?>">
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->url); ?></td>
    <td><?php echo Html::encode($model->local); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->default); ?></td>
    <td><?php echo Html::encode(date('d.m.y h:i:s',$model->date_update)); ?>
    </td>
    <td>
        <?php
        echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
            ['update', 'id'=>$model->id],['title'=>'Update']);
        ?>
        &nbsp;
      <?php
           echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',['delete', 'id'=>$model->id],
           [
             'title' => Yii::t('app', 'Delete'),
             'onclick'=>"if(confirm('Вы действительно хотите удалить?')) {
                $.ajax({
               type     :'post',
               cache    : false,
               url  : '".Url::toRoute(['delete','id'=>$model->id])."',
               success  : function(response) { $('#".$view_element."').remove();   }
           })
           }; return false; ",
          ]);
      ?> 
   </td>
</tr>