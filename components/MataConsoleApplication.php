<?php

class MataConsoleApplication extends CConsoleApplication {

	function __construct($config = null) {

		if ($this->isMataInstallation()) {
			parent::__construct($config);
			return;
		}


		$mataFolderPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "mata";
		Yii::setPathOfAlias("mata", $mataFolderPath);

		$mataConfig = require($mataFolderPath . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "console.php");
		$config = CMap::mergeArray($mataConfig, require($config));

		$this->setComponents(array(
			'matadb' => array(
				'class' => 'CDbConnection',
				)
			));

		parent::__construct($config);
		$this->initializeMataModules();
	}

	private function isMataInstallation() {
		return count($_SERVER['argv']) == 3 && $_SERVER['argv'][1] == "mata" && $_SERVER['argv'][2] == "install";
	}

	private function initializeMataModules() {

		$modules = Yii::app()->matadb->createCommand("select Name, Config from matamodule")->queryAll();

        // This logic means file overwrites db settings - is this correct?
		foreach ($modules as $module) {
			if (!$this->hasModule($module["Name"])) {

				$config = json_decode($module["Config"], true);

				if ($config == null || !$config["class"])
					throw new CHttpException(500, "Missing class definition for " . $module["Name"]);

				$this->setModules(array($module["Name"] => $config));
			}
		}
	}

	public function getMataDb() {
		return $this->getComponent('matadb');
	}
}
