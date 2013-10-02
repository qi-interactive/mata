<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />
        <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta HTTP-EQUIV="Expires" CONTENT="-1">
        <meta name="viewport" content="initial-scale = 1.0" />
        
        <link rel="shortcut icon" href="/favicon.png" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->mataAssetUrl ?>/css/tooltip.css" />

        <link rel="stylesheet" type="text/css" href="/css/main.css" />

        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->mataAssetUrl ?>/js/lib/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->mataAssetUrl ?>/js/lib/jquery.transit.min.js"></script>
        <script type="text/javascript" src="/js/main.js"></script>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <?php echo $content; ?>
    </body>
    <script type="text/javascript" src="//use.typekit.net/yho8kmm.js"></script>
    <script type="text/javascript">try {
            Typekit.load();
        } catch (e) {
        }
    </script>
</html>