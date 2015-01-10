<h1><?php echo Yii::t($this->module->getName(), Yii::app()->generateLabel($modelName) . "s") ?></h1>

<div class="nav-buttons floated top-right">
    <a class="btn-small btn" href="<?php echo $this->id ?>/create"><?php echo Yii::t($this->module->getName(), "Create New " . Yii::app()->generateLabel($modelName)) ?></a>
</div>
<p class="note"><?php
    echo Yii::t('mata', 'Clicking items with {icon} key reveals more options', array(
        '{icon}' => CHtml::image(Yii::app()->mataAssetUrl . "/images/" .
            (UserAgent::isMac() ? "mac-cmd-key-icon.png" : "pc-crtl-key-icon.png"), '', array(
                "class" => "keyboard-key-icon"
                ))
        ));
        ?></p>
        <?php
        $this->widget('mata.widgets.grid.MListView', array(
            'id' => "$modelNameLowerCase-grid",
            'dataProvider' => $model->search(),
            'itemView' => $this->getViewFile("_view") ? "_view" : "mata.views.mModule._view",
            'sortableAttributes' => $model->getSortableAttributes()
            ));
            ?>
