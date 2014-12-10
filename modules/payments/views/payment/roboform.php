Процесс оплаты... 
<form action='<?php print $model->url ?>' method="post" id="robo-form" >
    <input type="hidden" name="MrchLogin" value="<?php print $model->mrh_login ?>" />
    <input type="hidden" name="OutSum" value="<?php print $model->out_summ; ?>" />
    <input type="hidden" name="InvId" value="<?php print $model->inv_id ?>" />
    <input type="hidden" name="Desc" value="<?php print $model->inv_desc ?>" />
    <input type="hidden" name="SignatureValue" value="<?php print $model->crc ?>" />
    <input type="hidden" name="Shp_item" value="<?php print $model->shp_item ?>" />
    <input type="hidden" name="IncCurrLabel" value="<?php print $model->in_curr ?>" />
    <input type="hidden" name="Culture" value="<?php print $model->culture ?>" />
</form>
<script type="text/javascript">document.forms["robo-form"].submit();</script>