<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<tr>
    <td><?= $number ?></td>
    <td>
        <?php echo Html::a('MM100'.$model->id,['tcpdf', 'id'=>$model->id]); ?>
    </td>
    <td><?php echo Html::encode($model->name); ?></td>
    <td><?php echo Html::encode($model->date); ?></td>
    <td><?php echo Html::encode($model->client->name); ?></td>
    <td><?php echo Html::encode($model->company->name); ?></td>
    <td><?php echo Html::encode($model->price_service*$model->count); ?>&euro;</td>
    <td><?php echo Html::encode($model->price); ?>&euro; </td>
    <td><?php if ($model->is_pay) echo '<span class="invoce_valid hint-container"> <div class="hint-content">he Invoice is Valid</div><img src="/images/invoice_valid.png" /></span>';
        else echo '<a href="'.Url::toRoute(['user/pay', 'id'=>$model->id]).'"
        class="hint-container"><div class="hint-content">he Invoice is not Valid:<br />
the client must pay the VAT <br />
& the Income Tax</div><img src="/images/invoice_invalid.png" />';
        ?></td>
    <td>
        &nbsp;
        <?php
         if (\Yii::$app->user->can('superadmin')){ ?>
            <span class="pull-right">
                <?php echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
                    ['update', 'id'=>$model->id],['title'=>'Update']); ?>
                &nbsp;
                <?php echo Html::a('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>',
                    ['delete', 'id'=>$model->id],['title'=>'Delete', 'onClick'=>'return confirm("Вы действительно хотите удалить?")']); ?>
            </span>
        <?php } else { ?>
               <?php Modal::begin([
                   'header' => '<h2>Шаблон для печати</h2>',
                   'toggleButton' => ['tag'=>'a', 'label' => '<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>',
                       'style'=>'cursor:pointer;', 'title'=>'Set Template'],
               ]);
               echo 'Выберите шаблон:';
               echo Html::ol([
                       Html::a('Базовый',['settemplate','id'=>$model->id,'template'=>'basic']),
                       Html::a('Дополнительный',['settemplate','id'=>$model->id,'template'=>'add'])
                   ],
                   ['encode'=>false]);
               Modal::end();

             Modal::begin([
                 'header' => '&nbsp;',
                 'options'=>['class'=>'modal-pdf'],
                 'toggleButton' => ['tag'=>'a', 'label' => '<img src="/images/invoice_pdf.png" />',
                     'style'=>'cursor:pointer;', 'title'=>'View in Pdf'],
             ]);
/*               echo ' <iframe src="'.Url::toRoute(['tcpdf', 'id'=>$model->id]).'" width="800" height="600" align="left">
    Ваш браузер не поддерживает плавающие фреймы!
 </iframe>';*/
               Modal::end();
//             echo Html::a('<img src="/images/invoice_pdf.png"', ['tcpdf', 'id'=>$model->id],['title'=>'View in Pdf']);
             echo '&nbsp';
               echo Html::a('<img src="/images/invoice_print.png"', ['tcpdf', 'id'=>$model->id,'print'=>1],['title'=>'Print']);
               echo '&nbsp';
               echo Html::a('<span style="color: purple;" class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['tcpdf', 'id'=>$model->id, 'isTranslit'=>1],['title'=>'Print Translit']);
               ?>
        <?php }  ?>

    </td>
<!--    <td><?php echo Html::encode($model->count); ?></td>
    <td><?php echo Html::encode($model->vat); ?></td>
    <td><?php echo Html::encode($model->tax); ?></td>
    <td><?php echo Html::encode($model->discount); ?></td>
    <td><?php echo Html::encode($model->price); ?></td>-->
</tr>


</div>