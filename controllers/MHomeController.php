<?php

class MHomeController extends MMataController {

    public function actionIndex() {
        $this->pageTitle = Yii::app()->name . " - Dashboard";
        parent::actionIndex();
    }

    public function actionSetProject($projectId) {
        Yii::app()->user->setProject($projectId);

        $this->setResponseType("application/json");
        echo CJSON::encode($this->user->project);
    }
}

?>
