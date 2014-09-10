<?php 

// TODO Move this to a behavior or event-driven design

/**
* Description of VersionedDocumentController
*
* @author marcinwiatr
*/
abstract class MVersionedDocumentController extends MModuleController {

	public function actionGetVersions() {
		$model = $this->loadModel($this->getModelPkValue());

		if (array_key_exists("versions", $model->behaviors()))
			$this->renderPartial("mata.views.versions._versions", array(
				"versions" => $model->getAllVersions(),
				"model" => $model
				));
	}


	public function loadModel($id) {

		$model = $this->getModel()->findByPk($id);

		if (Yii::app()->getRequest()->getParam("rev")) {
			$revision = $model->getRevision(Yii::app()->getRequest()->getParam("rev"));
			$model->attributes = $revision->getModelAttributes();
		}

		if ($model === null)
			throw new CHttpException(404, 'The requested model does not exist.');
		return $model;
	}


}

?>
