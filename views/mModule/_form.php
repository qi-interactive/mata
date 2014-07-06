<div id="<?php echo get_class($model) ?>-form" class="form">
	<?php
	$widget = $this->widget('mata.widgets.MAutoActiveForm', array(
		'id' => "client-" . strtolower(get_class($model)),
		"model" => $model,
		'enableAjaxValidation' => true,
		));

	$widget->configSummary();

		?>
	</div>