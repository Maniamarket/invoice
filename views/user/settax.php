<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this ServiceController */
/* @var $dataProvider CActiveDataProvider */

$this->title=Yii::$app->name . ' - SetTax';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?php echo Yii::t('app', 'SetTaxHeaderText'); ?></h1>

<table class="table table-striped">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>SurTax</th>
        <th>Действия</th>
    </tr>
<?php 

    foreach ($datas as $data)
    {
        $view_element = 'settax_id'.$data['id'];
        $view_element_td = 'td_settax_id'.$data['id'];
    ?>    
    <tr id="<?php echo Html::encode($view_element); ?>">
    <td><?php echo Html::encode($data['id']); ?></td>
    <td><?php echo Html::encode($data['name']); ?></td>
    <td><?php echo Html::encode($data['email']); ?></td>
    <td><?php echo Html::textInput('surtax', $data['surtax'], ['id'=>$view_element_td]); ?></td>
    <td><?php 
            $url = Url::toRoute(['user/update','user_id'=>$data['id']]);
            echo Html::a('save',Url::toRoute(['user/update','user_id'=>$data['id']]),
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
    </tr>
<?php    } ?>
</table>
<?php  echo $pages; ?>

