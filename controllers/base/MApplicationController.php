<?php

class MApplicationController extends MController {

    public $layout = "mMainWithMenu";
    public function filters() {
        return array_merge(array(
            'registerCoreScript',
                ), parent::filters());
    }

    public function filterRegisterCoreScript($filterChain) {
        
        Yii::app()->clientScript->scriptMap = array(
            'jquery.js' => false,
        );
        
        $filterChain->run();
    }

}

?>
