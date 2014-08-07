<?php
$this->beginContent(file_exists(Yii::getPathOfAlias("application.views.layouts") . DIRECTORY_SEPARATOR . "mMataMain.php") ?
	'application.views.layouts.mMataMain' : 'mata.views.layouts.mMataMain');
	?>
	<?php
	foreach (Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
	}
	?>

	<div id="cms-form-content">
		<?php echo $content ?>
	</div>

	<?php $this->endContent(); ?>