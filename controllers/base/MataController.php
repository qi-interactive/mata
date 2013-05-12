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
    public $mataAssetUrl;

    public function filterBeforeExec($filterChain) {

        $this->mataAssetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('mata') . DIRECTORY_SEPARATOR . "assets", false, -1, YII_DEBUG);
        $cs = Yii::app()->getClientScript();

        $cs->registerScriptFile($this->mataAssetUrl . '/js/behaviors/dialogBox.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile($this->mataAssetUrl . '/js/behaviors/flashMessage.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile($this->mataAssetUrl . '/js/behaviors/multiOption.js', CClientScript::POS_BEGIN);
        $cs->registerScriptFile($this->mataAssetUrl . '/js/behaviors/retinaImages.js', CClientScript::POS_BEGIN);
        $cs->registerCssFile($this->mataAssetUrl . '/css/reset.css');
        $cs->registerCssFile($this->mataAssetUrl . '/css/layout.css');
        $cs->registerCssFile($this->mataAssetUrl . '/css/cmsFormContent.css');

        parent::filterBeforeExec($filterChain);
    }

}

?>
