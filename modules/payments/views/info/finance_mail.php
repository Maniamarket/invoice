<p>Запрошен вывод средств на сумму $<?php print abs($history->amount) ?></p>
<br/>

<p>Реквизиты платежа:</p>
<p><?php print $history->information ?></p>
<br/>

<p>Информация о пользователе: <?php print $this->createAbsoluteUrl('/admin/users/view/', array('id' => $history->user_id)) ?></p>
<p>Информация о заявке: <?php print $this->createAbsoluteUrl('/admin/info/payment/', array('id' => $history->id)) ?></p>