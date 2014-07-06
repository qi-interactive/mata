<h1><?php echo Yii::t("mata", "Create") . " " . $model->generateAttributeLabel($modelName) ?></h1>


<p><?php echo $model->generateAttributeLabel($modelName) ?></p>


<?php echo $this->renderPartial(file_exists($this->getViewFile("_form")) ? "_form" : 'mata.views.module._form', array('model' => $model));
?>