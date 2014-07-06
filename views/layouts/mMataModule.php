<?php
$this->beginContent(file_exists(Yii::getPathOfAlias("application.views.layouts") . DIRECTORY_SEPARATOR . "mataMain.php") ?
                'application.views.layouts.mataMain' : 'mata.views.layouts.mataMain');
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