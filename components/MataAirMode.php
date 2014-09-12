<?php 

class MataAirMode extends CComponent {

	public function init() {

	}

	public function register() {
		
		$mataModules = Yii::app()->getMataModules();

		foreach ($mataModules as $module) {
			$module = Yii::app()->getModule($module["Name"]);
			if ($this->hasAirModeClient($module))
				$module->airMode();
		}
	}

	private function hasAirModeClient($module) {
		return method_exists($module, "airMode"); 
	}
}