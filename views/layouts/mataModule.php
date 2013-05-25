<?php
$this->beginContent(file_exists(Yii::getPathOfAlias("application.views.layouts") . DIRECTORY_SEPARATOR . "main.php") ?
                'application.views.layouts.main' : 'mata.views.layouts.main');
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