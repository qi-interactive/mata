<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../yii/framework/yiic.php';
$config=dirname(__FILE__).'/config/console.php';

// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once(dirname(__FILE__).'/../yii/framework/yii.php');
require_once(dirname(__FILE__) . '/components/MataConsoleApplication.php');

if(isset($config))
{
  $app=Yii::createApplication("MataConsoleApplication", $config);
  $app->commandRunner->addCommands(YII_PATH.'/cli/commands');
}
else
  $app=Yii::createApplication("MataConsoleApplication", array('basePath'=>dirname(__FILE__).'/cli'));


$env=@getenv('YII_CONSOLE_COMMANDS');
if(!empty($env))
  $app->commandRunner->addCommands($env);




$app->run();
