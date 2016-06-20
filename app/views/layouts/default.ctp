<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		<?php __('Event:'); ?>
		<?php echo $pageTitle; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
	?>
	<?php echo $this->Html->script('jquery-1.10.2.min');?>
	<?php echo $this->Html->script('bootstrap.min');?>
	<?php echo $this->Html->script('jquery-ui-1.11.4.custom/jquery-ui.min');?>
	<?php echo $this->Html->script('common');?>
	<?php echo $this->Html->css('bootstrap.min');?>
	<?php echo $this->Html->css('jquery-ui-1.11.4.custom/jquery-ui.min');?>
	<?php echo $this->Html->css('font_awesome/css/font-awesome.min');?>
	<?php echo $scripts_for_layout; ?>
</head>
<body>
	<div class="container">
		<div class="page-header">
			<h1><?php echo __('Event System'); ?></h1>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
		</div>
		<div id="footer">
			Copywright @<?php echo date('Y');?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>