<?php

class MataCommand extends CConsoleCommand {

	public $defaultAction = "install";
	public $interactive = 1;

	public function actionInstall($args = array()) {


		if (empty($args) == false) {
			list($type, $name) = $args;

			if ($type == "module") {
				$this->installModule($name);
			} else {
				$this->printLine("Unknown operation install $type");
			}
			return;
		}
		$this->printLine("Welcome to MATA installation.");

		$response = $this->prompt("Would you like to install MATA? (yes|no)");

		if ($response != "yes")
			$this->emptyLine()->printLine("Terminating. Have a nice day!")->emptyLine();


		$dbName = "yii-app-mata-template";
		$host = "83.170.88.249";
		$username = "yiimataapptempla";
		$password = "CHcxjvLs";


		do {

			// $host = $this->prompt("Host (IP address or URL): ");
			// $dbName = $this->prompt("Database Name: ");
			// $username = $this->prompt("Username: ");
			// $password = $this->prompt("Password: ");

			echo "Testing connection: ";
		} while ($this->checkDbCredentials($host, $dbName, $username, $password) == false);


		$this->printLine(" OK")->printLine("Saving database settings to config file (mataDb component)");

		if ($this->saveDbSettingsToConfigFile($host, $dbName, $username, $password) === false) {
			$this->printLine("Could not save config file");
			exit;
		}

		$this->printLine("Configuration written to dev.php and console.php file");

		$this->printLine("Launching migrations tool")->emptyLine()->emptyLine();
		$this->runMigration();
		$this->installPresetModules();

		$this->emptyLine()->emptyLine()->printLine("Thank you for installing Mata.")->printLine("You can now access it using this URL: ");
		$this->emptyLine();
	}



	private function installPresetModules() {

		$preloadFile = Yii::getPathOfAlias("application.config.findABetterName") . ".php";

		if (file_exists($preloadFile)) {
			$preloadModules = require($preloadFile);

			foreach($preloadModules as $module) {
				$this->emptyLine()->printLine("Installing $module")->emptyLine();
				$this->installModule($module);
			}
		}




	}

	private function runModuleInstaller($moduleId) {
		$this->runModuleMigrationTool($moduleId);
		// $this->registerModuleWithMata();


	}

	private function registerModuleWithMata() {


		// Yii::import("application.models.base.*");
		// Yii::import("application.models.*");

		// $order = MataModuleGroup::model()->find(array(
		// 	"order" => "Order DESC",
		// 	"select" => "Order"
		// 	));

		// echo $order;

		$model = new MataModuleGroup();
		$model->attributes(array(
			"Name" => "Content Block"
			));
	}


	private function runModuleMigrationTool($moduleId) {
		$commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
		$runner = new CConsoleCommandRunner();
		$runner->addCommands($commandPath);
		$commandPath = Yii::getFrameworkPath() . DIRECTORY_SEPARATOR . 'cli' . DIRECTORY_SEPARATOR . 'commands';
		$runner->addCommands($commandPath);

		$args = array('yiic', 'migrate', '--interactive=0', '--connectionID=matadb', '--migrationTable=matainstallationmigration',
			"--migrationPath=application.modules.$moduleId.migrations");
		$runner->run($args);
	}

	private function runMigration() {
		$app = Yii::app();
		if ($app === null) return;

		$args = array("yiic", "migrate", '--interactive=0', '--connectionID=matadb', '--migrationTable=matainstallationmigration');
		$app->commandRunner->addCommands(\Yii::getPathOfAlias('system.cli.commands'));
		$app->commandRunner->run($args);
	}

	private function checkDbCredentials($host, $dbName, $username, $password) {
		error_reporting(E_ALL ^ E_WARNING);

		try {
			$connection = new CDbConnection("mysql:host=$host;dbname=$dbName", $username, $password);
			$connection->active = true;
		} catch (Exception $e) {
			echo " FAILED: " . $e->getMessage();
			$this->emptyLine()->emptyLine()->printLine("Check your settings and try again:");
			return false;
		}

		return true;
	}

	private function saveDbSettingsToConfigFile($host, $dbName, $username, $password) {

		$configFilePath = __DIR__ . DIRECTORY_SEPARATOR .  ".." .
		DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR;

		$contents = file_get_contents($configFilePath . "dev.php");

		$contents = str_replace("'matadb' => array()","'matadb' => array(
			'class' => 'system.db.CDbConnection',
			'connectionString' => 'mysql:host=$host;dbname=$dbName',
			'emulatePrepare' => true,
			'username' => '$username',
			'password' => '$password',
			'charset' => 'utf8',
			'enableParamLogging' => true
			)", $contents);

		file_put_contents($configFilePath . "dev.php", $contents);

		$contents = file_get_contents($configFilePath . "console.php");

		$contents = str_replace("'matadb' => array()","'matadb' => array(
			'class' => 'system.db.CDbConnection',
			'connectionString' => 'mysql:host=$host;dbname=$dbName',
			'emulatePrepare' => true,
			'username' => '$username',
			'password' => '$password',
			'charset' => 'utf8',
			'enableParamLogging' => true
			)", $contents);

		Yii::app()->setComponents(array(
			'matadb' => array(
				'class' => "system.db.CDbConnection",
				"connectionString" => "mysql:host=$host;dbname=$dbName",
				"emulatePrepare" => true,
				"username" => "$username",
				"password" => "$password",
				"charset" => "utf8",
				"enableParamLogging" => true
				)
			));

		$response = file_put_contents($configFilePath . "console.php", $contents);


		return $response;

	}

	private function printLine($s) {
		echo $s . "\n\r";
		return $this;
	}
	private function emptyLine() {
		echo "\n\r";
		return $this;
	}

	private function installModule($moduleId) {
		$this->printLine("Checking availibility of $moduleId");

		if ($this->urlExists("http://matacms.localhost/modules/$moduleId.mata")) {
			$agreeToInstall = $this->prompt("$moduleId verified. Would you like to install? (yes|no)");

			if ($agreeToInstall == "yes") {
				$modulesFolderPath = __DIR__ . DIRECTORY_SEPARATOR .  ".." .
				DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR;

				$modulePath =  $modulesFolderPath . "$moduleId.mata";

				if (file_put_contents($modulePath, $this->getModule($moduleId)) === false) {
					$this->printLine("Could not store file in this location $modulePath, possibly permissions problem?");
				}

				$zip = new ZipArchive;
				$res = $zip->open($modulePath);
				if ($res === TRUE) {
					$zip->extractTo($modulesFolderPath);
					$zip->close();

					unlink($modulePath);
					$this->printLine("Module uncompressed. Running module installation");
					$this->runModuleInstaller($moduleId);

					$this->printLine("Module $moduleId installed successfully. Have a nice day!")->emptyLine();
				} else {
					$this->printLine("Could not unzip MATA module. Sorry!");
				}

			} else {
				$this->printLine("Maybe next time. Have a nice day!");

			}
		} else {
			$this->printLine("$moduleId is not available. Check the moduleId and try again");
			exit;
		}
	}

	public function prompt($msg) {

		if ($this->interactive == 1)
			return parent::prompt($msg);

		return "yes";
	}

	private function getModule($moduleId) {
		return $this->callAPI("GET", "http://matacms.localhost/modules/$moduleId.mata", false);
	}

	function urlExists($url=NULL)
	{
		if($url == NULL) return false;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($httpcode>=200 && $httpcode<300){
			return true;
		} else {
			return false;
		}
	}


	private function callAPI($method, $url, $data = false, $authenticate = true, $userCredentials = 'wichura:d75c0bfb6f69a4652a70d221032bee6c327cd894') {
		$curl = curl_init();
		switch ($method) {
			case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);

			if ($data)
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;
			case "PUT":
			curl_setopt($curl, CURLOPT_PUT, 1);
			break;
			default:
			if ($data)
				$url = sprintf("%s?%s", $url, http_build_query($data));
		}

	    // Optional Authentication:
		if ($authenticate) {
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, $userCredentials);
		}

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		return curl_exec($curl);
	}
}


