<h1><?php echo Yii::t("mata", "Create") . " " . Yii::t($this->module->getName(), $modelName) ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>