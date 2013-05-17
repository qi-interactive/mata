<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataController
 *
 * @author wichura
 */
class MataController extends BaseAuthorizedController {

    public $layout = "mainWithMenu";

    public function filterBeforeExec($filterChain) {
        $this->addClientScript();
        parent::filterBeforeExec($filterChain);
        $this->setLanguage();
    }

    private function addClientScript() {
        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile(Yii::app()->mataAssetUrl . '/js/mata.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile(Yii::app()->mataAssetUrl . '/js/behaviors/dialogBox.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile(Yii::app()->mataAssetUrl . '/js/behaviors/flashMessage.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile(Yii::app()->mataAssetUrl . '/js/behaviors/multiOption.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile(Yii::app()->mataAssetUrl . '/js/behaviors/retinaImages.js', CClientScript::POS_BEGIN);
        $cs->registerCssFile(Yii::app()->mataAssetUrl . '/css/reset.css');
        $cs->registerCssFile(Yii::app()->mataAssetUrl . '/css/layout.css');
        $cs->registerCssFile(Yii::app()->mataAssetUrl . '/css/cmsFormContent.css');
    }

    private function setLanguage() {
        Yii::app()->language = Yii::app()->user->project->Language;
    }

}

?>
