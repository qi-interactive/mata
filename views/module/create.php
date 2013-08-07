<h1><?php echo Yii::t("mata", "Create") . " " . Yii::t($this->module->getName(), $modelName) ?></h1>


<?php echo $this->renderPartial(file_exists($this->getViewFile("_form")) ? "_form" : 'mata.views.module._form', array('model' => $model));
?>