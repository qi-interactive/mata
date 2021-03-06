<?php

/**
 * Description of MVersionedModelBehavior
 *
 * @author marcinwiatr
 */
class MVersionedModelBehavior extends CActiveRecordBehavior {

    protected static $REQUEST_KEY_SAVE_MODE = "saveMode";
    protected static $REQUEST_VALUE_PUBLISH_MODE = "publish";

    public function afterSave($event) {
        $this->saveNewVersion();
    }

    private function saveNewVersion() {

        $version = new DocumentVersion();
        $latestVersion = $this->getLatestVersion();

        $revision = $latestVersion != null ? ++$latestVersion->Revision : 1;

        $version->attributes = array(
            "DocumentId" => $this->getDocumentId(),
            "Revision" => $revision,
            "CreatorUserId" => Yii::app()->user->getId(),
            "ModelAttributes" => serialize($this->getOwner()->attributes),
            "IsPublished" => Yii::app() instanceof CConsoleApplication ||
            (Yii::app()->user->checkAccess("publisher") &&
                Yii::app()->getRequest()->getParam(self::$REQUEST_KEY_SAVE_MODE, 0) == self::$REQUEST_VALUE_PUBLISH_MODE)
            );

        if ($version->save() === false) {
            // TODO Implement better error handling, add reason
            throw new CHttpException(500, "Could not save version " . $version->getFirstError());
        }
    }

    private function getDocumentId() {

        $pk = $this->getOwner()->getPrimaryKey();
        if (is_array($pk))
            $pk = implode('-', $pk);

        return get_class($this->getOwner()) . $pk;
    }

    public function getLatestVersion() {
        return DocumentVersion::model()->findByAttributes(array(
            "DocumentId" => $this->getDocumentId()
            ), array(
            "order" => "Revision DESC"
            ));
    }

    public function getRevision($revision) {
        return DocumentVersion::model()->findByAttributes(array(
            "DocumentId" => $this->getDocumentId(),
            "Revision" => $revision
            ), array(
            "order" => "Revision DESC"
            ));
    }

    public function getAllVersions() {
        return DocumentVersion::model()->findAllByAttributes(array(
            "DocumentId" => $this->getDocumentId()
            ), array(
            "order" => "Revision DESC"
            ));
    }

    public function getNewestPublishedVersion() {
        return DocumentVersion::model()->findByAttributes(array(
            "DocumentId" => $this->getDocumentId(),
            "IsPublished" => 1
            ), array(
            "order" => "Revision DESC"
            ));
    }

}