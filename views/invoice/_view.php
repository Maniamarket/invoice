<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td><?= $number ?></td>
    <td>
        <?php echo Html::encode('MM100'.$model->id); ?>
    </td>
    <td><?php echo Html::encode(date('d/m/Y', strtotime($model->date))); ?></td>
    <td><?php echo Html::encode($model->client->name); ?></td>
    <td><?php echo Html::encode($model->company->name); ?></td>
    <td><?php echo Html::encode($model->net_price); ?>&euro;</td>
    <td><?php echo Html::encode($model->total_price); ?>&euro; </td>
    <td><?php if ($model->is_pay) echo '<span class="invoce_valid hint-container"> <div class="hint-content">he Invoice is Valid</div><img src="/images/invoice_valid.png" /></span>';
        else echo '<a href="'.Url::toRoute(['user/pay', 'id'=>$model->id]).'"
        class="hint-container"><div class="hint-content">he Invoice is not Valid:<br />
the client must pay the VAT <br />
& the Income Tax</div><img src="/images/invoice_invalid.png" />';
        ?></td>
    <td>
        &nbsp;
        <?php
         if (Yii::$app->user->can('superadmin') || ((Yii::$app->user->id == $model->user_id) && !$model->is_pay)){ ?>
            <span class="pull-right">
                <?php echo Html::a('<img src="/images/edit.png" />',
                    ['update', 'id'=>$model->id],['title'=>'Update']); ?>
                &nbsp;
                <?php echo Html::a('<img src="/images/delete.png" />',
                    ['delete', 'id'=>$model->id],['title'=>'Delete', 'onClick'=>'return confirm("Вы действительно хотите удалить?")']); ?>
            </span>
        <?php }
        //                  if( Yii::$app->user->can('superadmin') || Yii::$app->user->id == $model->user_id)
 //                     echo Html::a('edit', ['update', 'id'=>$model->id],['title'=>'Edit']);
/*               Modal::begin([
                   'header' => '<h2>Шаблон для печати</h2>',
                   'toggleButton' => ['tag'=>'a', 'label' => '<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>',
                       'style'=>'cursor:pointer;', 'title'=>'Set Template'],
               ]);
               echo 'Выберите шаблон:';
               echo Html::ol([
                       Html::a('Третий',['settemplate','id'=>$model->id,'template'=>'basic']),
                       Html::a('Второй',['settemplate','id'=>$model->id,'template'=>'second']),
                       Html::a('Третий',['settemplate','id'=>$model->id,'template'=>'third'])
                   ],
                   ['encode'=>false]);
               Modal::end();*/

             echo Html::a('<img src="/images/invoice_pdf.png"', ['tcpdf', 'id'=>$model->id],['title'=>'View in Pdf',
                 'onclick'=>'$("#iframe-pdf").attr("src","'.Url::toRoute(['tcpdf', 'id'=>$model->id]).'"); return false;', 'data-toggle'=>"modal", 'data-target'=>"#modal-pdf"]);
             echo '&nbsp';
               echo Html::a('<img src="/images/invoice_print.png"', ['tcpdf', 'id'=>$model->id,'print'=>1],['title'=>'Print']);
               echo '&nbsp';
               echo Html::a('<span style="color: purple;" class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['tcpdf', 'id'=>$model->id, 'isTranslit'=>1],['title'=>'Print Translit']);
               ?>

    </td>
</tr>


</div>