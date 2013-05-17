<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataInstallerController
 *
 * @author wichura
 */
class MataInstallerController extends CController {

    public $defaultAction = "welcome";

    public function actionWelcome() {

        $model = new MataInstallerForm();

        if (isset($_POST["MataInstallerForm"])) {
            $model->attributes = $_POST["MataInstallerForm"];
            if ($model->validate()) {
                $this->install($model);
                Yii::app()->end();
            }
        }

        $this->render("welcome", array(
            "model" => $model
        ));
    }

    private function install($model) {

        $this->render("success", array(
            "model" => $model
        ));
    }

}

?>
