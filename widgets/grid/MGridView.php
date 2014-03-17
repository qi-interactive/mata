<?php 


Yii::import("zii.widgets.grid.CGridView");

class MGridView extends CGridView {


	public function init() {
		if($this->baseScriptUrl===null)
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';

		parent::init();
	}

}