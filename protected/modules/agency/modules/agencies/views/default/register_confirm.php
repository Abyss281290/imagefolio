<?php
// we have $model var here with registered agency
$this->title = 'Agency Confirmation';
$this->pageTitle = 'Agency Confirmation';
?>

<div style="font-size: 150%">
Your account is now confirmed, please <?php echo CHtml::link('click here', $this->createUrl('/site/login')); ?> 
to log in to complete setting up your agency and choose an appropriate package option.
</div>