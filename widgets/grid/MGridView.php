<?php 

Yii::import("zii.widgets.grid.CGridView");

class MGridView extends CGridView {

	public $mataBaseScriptUrl;
	public $pager = array('class'=>'mata.widgets.pagers.MLinkPager');

	public function init() {
		$this->cssFile = false;
		parent::init();
	}

	public function run() {

		$path = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('mata.widgets.assets').'/gridView',  false, -1, YII_DEBUG);
		Yii::app()->getClientScript()->registerCssFile($path . '/css/MGridView.css');

		parent::run();

	}

}