<?php
use yii\widgets\ListView;
?>
<?php
 echo ListView::widget([
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'layout' => "{items}\n{pager}"
]);
?>
