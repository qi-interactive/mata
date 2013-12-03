<?php

class MataCommand extends CConsoleCommand {


	public $defaultAction = "install";

	public function actionInstall() {
		// $this->printLine("Welcome to MATA installation.");

		// $response = $this->prompt("Would you like to install MATA? (yes|no)");

		// if ($response != "yes")
		// 	$this->emptyLine()->printLine("Terminating. Have a nice day!")->emptyLine();


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

		$this->printLine("Configuration written to dev.php file");
		$this->printLine("Launching migrations tool")->emptyLine()->emptyLine();
		$this->runMigration();


		$this->emptyLine()->emptyLine()->printLine("Thank you for installing Mata.")->printLine("You can now access it using this URL: ");
		$this->emptyLine();
	}


	private function runMigration() {
		$app = Yii::app();
		if ($app === null) return;

		$args = array("yiic", "migrate");
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
		DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "dev.php";

		$contents = file_get_contents($configFilePath);

		$contents = str_replace("'matadb' => array()","'matadb' => array(
			'connectionString' => 'mysql:host=$host;dbname=$dbName',
			'emulatePrepare' => true,
			'username' => '$username',
			'password' => '$password',
			'charset' => 'utf8',
			'enableParamLogging' => true
			)", $contents);

		return file_put_contents($configFilePath, $contents);

	}

	private function printLine($s) {
		echo $s . "\n\r";
		return $this;
	}
	private function emptyLine() {
		echo "\n\r";
		return $this;
	}
}


