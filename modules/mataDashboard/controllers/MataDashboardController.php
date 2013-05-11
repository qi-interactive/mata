<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataDashboardController
 *
 * @author wichura
 */
class MataDashboardController extends MataController {

    public $layout = 'mata.views.layouts.mataModule';

    public function getModel() {
        return null;
    }

    public function actionIndex() {
        parent::actionIndex();
    }

}

?>
