<h1><?php echo Yii::t($this->module->getName(), $modelName . "s") ?></h1>
<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="<?php echo $modelNameLowerCase ?>/create"><?php echo Yii::t($this->module->getName(), "Create New " . $modelName) ?></a>
</div>
<p class='note'>Clicking items with <img class="keyboard-key-icon" src='<?php echo Yii::app()->mataAssetUrl ?>/images/<?php echo UserAgent::isMac() ? "mac-cmd-key-icon.png" : "pc-crtl-key-icon.png" ?>'  /> key reveals more options</p>

<?php
$this->widget('mata.widgets.MListView', array(
    'id' => "$modelNameLowerCase-grid",
    'dataProvider' => $model->search(),
    'itemView' => $this->getViewFile("_view") ? "_view" : "mata.views.module._view",
    'sortableAttributes' => $model->getSortableAttributes()
));
?>
