<?php
$tmp = $items;
$items = array();
foreach($tmp as $item) {
	$items[$item->category_id][$item->id] = $item;
}
?>
<?php if(count($items)): ?>
<div class="content">
	<?php foreach($items as $category_id => $contents): ?>
	<h1><?php echo $categories[$category_id]->title; ?></h1>
		<?php
			foreach($contents as $item):
				$urlView = Yii::app()->createUrl('/content/index/', array('id' => $item->id));
		?>
		<div class="box">
			<?php echo CHtml::link(CHtml::image($item->image->src['full']), $urlView); ?>
			<h3><?php /* <span>123</span>*/ ?><?php echo CHtml::link($item->title, $urlView); ?></h3>
			<?php echo $item->short_content; ?>
			<?php /* <url><a href="#">www.siteweb.com</a></url> */ ?>
			<div class="clear"></div>
		</div>
		<?php endforeach; ?>
	<?php endforeach; ?>
</div>
<?php endif; ?>