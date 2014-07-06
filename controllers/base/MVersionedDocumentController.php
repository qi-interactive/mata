<?php 

// TODO Move this to a behavior or event-driven design

/**
* Description of VersionedDocumentController
*
* @author marcinwiatr
*/
abstract class MVersionedDocumentController extends MModuleController {

// 	public function actionView($id) {
// /**
// * So far the view has got only single responsibility (CMS Message), hence the check
// * This is likely to change at some point in the future, in which case this logic should 
// * get updated 
// */
// if (isset($_POST["CMSMessage"])) {
// 	$this->redirect(array("update", "id" => $id));
// } else {
// 	$this->render('view', array(
// 		'model' => $this->loadModel($id),
// 		));
// }
// }

// public function actionUnpublish($id) {
// 	$model = $this->loadModel($id);
// 	$publishedVersion = $model->getNewestPublishedVersion();

// 	if ($publishedVersion) {
// 		$publishedVersion->IsPublished = 0;
// 		if ($publishedVersion->update() == 0) {
// 			throw new CHttpException(500, "Could not unpublish version!");
// 		}
// 	}
// }

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
