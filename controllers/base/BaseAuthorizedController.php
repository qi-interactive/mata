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
class BaseAuthorizedController extends BaseApplicationController {

    protected $user;

    public function filterBeforeExec($filterChain) {
        $this->authorize();
        parent::filterBeforeExec($filterChain);
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

}