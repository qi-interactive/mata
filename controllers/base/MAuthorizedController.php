<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseAuthorizedController
 *
 * @author wichura
 */
class MAuthorizedController extends MApplicationController {

    protected $user;
    public $layout = "mata.views.layouts.mMainWithMenu";

    public function filterBeforeExec($filterChain) {
        // $this->authorize();
        parent::filterBeforeExec($filterChain);
        // $this->setLanguage();
    }

    private function authorize() {

        if (Yii::app()->user->isGuest) {
            if (Yii::app()->request->getIsAjaxRequest()) {
                throw new CHttpException(403, "Resource unavailable");
            } else {
                Yii::app()->user->loginRequired();
            }
        }

        $this->user = Yii::app()->user;
    }
    
    private function setLanguage() {
        Yii::app()->language = Yii::app()->user->project->Language;
    }


}