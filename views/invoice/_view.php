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
    <td><?php
        Modal::begin([
            'header' => '<h2>Comments</h2>',
            'options'=>['class'=>'modal-grey', 'id'=>'comment_form'.$model->id],
            'toggleButton' => ['tag'=>'a', 'label' => '<img src="/images/comments.png" />',
                'style'=>'cursor:pointer;', 'title'=>'Comments'],
//            'size' => 'modal-sm',
        ]);
        echo '<div class="row"><div class="col-sm-12">';
        echo Html::textarea('notes',$model->notes,['class' => 'form-control']);
//        echo '</div>';
        echo '</div>';
        echo '<div class="col-sm-5" style="padding-top: 10px;">';
        echo Html::a('Submit', '#',['title'=>'', 'class' => 'btn btn-yellow',
                        'onclick'=>'
                        url = "'.Url::toRoute(['ajax_comment','id'=>$model->id]).'";
    $.ajax({
        url:url,
        method:"POST",
        data:{
            notes: $(this).parent().prev().children().eq(0).val()
        },
        success: function(response) { $("#comment_form'.$model->id.'").modal("hide"); },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.responseText);
            $("#comment_form'.$model->id.'").modal("hide");
       }
    });
      return false;'
        ]);
        echo '</div>';
        Modal::end();
        ?></td>
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
        echo Html::a('<img src="/images/invoice_pdf.png" />', ['tcpdf', 'id'=>$model->id],['title'=>'View in Pdf',
            'onclick'=>'$("#iframe-pdf").attr("src","'.Url::toRoute(['tcpdf', 'id'=>$model->id]).'"); return false;', 'data-toggle'=>"modal", 'data-target'=>"#modal-pdf"]);
        echo '&nbsp';
        //                  if( Yii::$app->user->can('superadmin') || Yii::$app->user->id == $model->user_id)
 //                     echo Html::a('edit', ['update', 'id'=>$model->id],['title'=>'Edit']);
               Modal::begin([
                   'header' => '<h2>Print</h2>',
                   'options'=>['class'=>'modal-grey'],
                   'toggleButton' => ['tag'=>'a', 'label' => '<img src="/images/invoice_print.png" />',
                       'style'=>'cursor:pointer;', 'title'=>'Print'],
              'size' => 'modal-sm',
               ]);
               echo '<p>Choose what you want to print</p>';
        echo '<div class="row"><div class="col-sm-6">';
        echo Html::a('Invoice', ['tcpdf', 'id'=>$model->id,'print'=>1],['title'=>'Print Invoice',
            'class'=>'invoice btn btn-default',
            'onclick'=>'isTrans=0; if ($(this).parent().next().next().children().eq(0).prop("checked")) isTrans=1;
            url = $(this).attr("href")+"&isTranslit="+isTrans;
            window.location.href=url; return false;'
        ]);
        echo '</div>';
        echo '<div class="col-sm-4">';
        echo Html::a('Receipt', ['receipt', 'id'=>$model->id,'isTranslit'=>0],['title'=>'Print Invoice',
            'class'=>'receipt btn btn-default',
            'onclick'=>'isTrans=0; if ($(this).parent().next().children().eq(0).prop("checked")) isTrans=1;
            url = $(this).attr("href")+"&isTranslit="+isTrans;
            window.location.href=url; return false;'
        ]);
        echo '</div>';
        echo '<div class="col-sm-8" style="padding-top: 10px;">';
        echo Html::checkbox('translit', false,['title'=>'',
/*            'onclick'=>'isTrans=0; if ($(this).prop("checked")) isTrans=1;
            url = $(this).parent().prev().children().eq(0).attr("href");
            url = url.substring(0, url.length - 1)+isTrans;
            $(this).parent().prev().children().eq(0).attr("href", url);
            alert($(this).parent().prev().children().eq(0).attr("href"));'*/
        ]);
        echo '&nbsp;'.Html::label('Transliteration');
        echo '</div></div>';
/*               echo Html::ol([
                       Html::a('Третий',['settemplate','id'=>$model->id,'template'=>'basic']),
                       Html::a('Второй',['settemplate','id'=>$model->id,'template'=>'second']),
                       Html::a('Третий',['settemplate','id'=>$model->id,'template'=>'third'])
                   ],
                   ['encode'=>false]);*/
               Modal::end();

//               echo Html::a('<span style="color: purple;" class="glyphicon glyphicon-print" aria-hidden="true"></span>', ['tcpdf', 'id'=>$model->id, 'isTranslit'=>1],['title'=>'Print Translit']);
               ?>

    </td>
</tr>


</div>