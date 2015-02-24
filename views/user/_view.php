<?php
use yii\helpers\Html;
use yii\helpers\Url;

$view_element_td = 'td_tax_id'.$model->id;
?>

<tr>
    <td><?php echo Html::encode($model->id); ?></td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->credit); ?></td>
    <td><?php echo Html::encode($model->sum_profit); ?></td>
    <?php if( $type_user == 4 ){ ?>
        <td><?php echo Html::textInput('percent', $model->surtax, ['id'=>$view_element_td]); ?></td>
        <td>
            <?php
            $url = Url::toRoute(['user/update','user_id'=>$model->id]);
            echo Html::a('save',$url,
                [
                    'title' => Yii::t('yii', 'Save'),
                    'class' => 'btn btn-primary btn-xs',
                    'onclick'=>"{  var surtax = $('#".$view_element_td." ').val();
               $.ajax({
               url  : '".$url."',
               type :'POST',
               data: {'surtax': surtax},
               success  : function(response) { $('#".$view_element_td."').empty().html(response).focus();   }
             })}; return false; ",
                ]);
            ?>
        </td>
        <td>
            <?php
            $url = Url::toRoute(['invoice/history','id'=>$model->id]);
            echo Html::a('go history credit',$url,  [  ]);
            ?>
        </td>
        <td>
            <?php
            $url = Url::toRoute(['paymentbanktrans/history','id'=>$model->id]);
            echo Html::a('go history bank transfer',$url,  [  ]);
            ?>
        </td>
        <td>
            <?php
            $url = Url::toRoute(['user/add_credit','id'=>$model->id]);
            echo Html::a('add credit',$url,  [  ]);
            ?>
        </td>
    <?php } ?>
    <?php  if( $type_user > 1  && $type_user < 4){ ;?>
        <td><?php  echo ($model->profit_manager) ?></td>
        <td><?php  echo ($model->sum_profit_manager) ?></td>
     <?php } ?>
     <?php  if( $type_user > 2 && $type_user < 4){ ;?>
        <td><?php  echo ($model->profit_admin) ?></td>
        <td><?php  echo ($model->sum_profit_admin) ?></td>
     <?php } ?>
     <?php  if( $type_user > 1 && $type_user < 4){ ;?>
        <td><?php  echo ($model->income) ?></td>
        <td><?php  echo ($model->my_profit) ?></td>
     <?php } ?>

</tr>
