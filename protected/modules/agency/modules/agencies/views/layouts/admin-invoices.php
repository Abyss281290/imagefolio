<?php
$this->beginContent('//layouts/admin', array('footer'=>$this->renderPartial('/invoices/payment_info', null, true)));
echo $content;
$this->endContent();
?>