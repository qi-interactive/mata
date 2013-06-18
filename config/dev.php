<?php

return array(
    'name' => 'Mata CMS',
    'defaultController' => "mata/Home",
    'import' => array(
        'mata.models.base.*',
        'mata.models.*',
        'mata.modules.base.*',
        'mata.controllers.base.*',
        'mata.widgets.base.*',
        "mata.helpers.*",
        'mata.modules.project.models.*',
    ),
    'modules' => array(
        'user' => array(
            'class' => "mata.modules.user.UserModule",
            'hash' => 'sha1',
            'sendActivationMail' => false,
            'activeAfterRegister' => true,
            'autoLogin' => false,
            'tableUsers' => "user",
            "tableProfiles" => "userprofile",
            "tableProfileFields" => "userprofilefield",
            'returnUrl' => "/",
            'captcha' => array('registration' => false)
        ),
        "media" => array(
            "class" => "mata.modules.media.MediaModule",
            "baseMediaPath" => "http://media.icodesign.com/"
        ),
        "mataDashboard" => array(
            "class" => "mata.modules.mataDashboard.MataDashboardModule",
        ),
        'project' => array(
            "class" => "mata.modules.project.ProjectModule",
        ),
        'installer' => array(
            "class" => "mata.modules.installer.MataInstallerModule",
        ),
        'mataAdmin' => array(
            "class" => "mata.modules.mataAdmin.MataAdminModule",
            'defaultController' => "mataAdmin"
        )
    ),
    'components' => array(
        'user' => array(
            'class' => 'mata.modules.user.components.WebUser',
        ),
        'keyValue' => array(
            "class" => "mata.extensions.KeyValue"
        ),
        'eventLog' => array(
            "class" => "mata.extensions.SystemEventLog"
        ),
        'googleApis' => array(
            'class' => 'mata.extensions.googleApis.GoogleApis',
            // See http://code.google.com/p/google-api-php-client/wiki/OAuth2
            'clientId' => '526658062115.apps.googleusercontent.com',
            'clientSecret' => 'm5DclALulijkyZodV3MJKU0p',
            'redirectUri' => 'http://new.matacms.com/mata/dashboard/getUserStatsFromGoogleAnalytics',
            // // This is the API key for 'Simple API Access'
            'developerKey' => 'AIzaSyBgbvhN5-awrJnZWIOu-ks276-UrwE9YrQ',
        ),
        'matadb' => array(),
        'clientScript' => array(
            'packages' => array(
                'bbq' => array(
                    'basePath' => "webroot.js.lib",
                    'js' => array('jquery.ba-bbq.js'),
                    'coreScriptPosition' => CClientScript::POS_HEAD
                ),
                'jquery' => false
            )
        ),
        'messages' => array(
            "class" => "CDbMessageSource",
            "connectionID" => "matadb",
            "sourceMessageTable" => "sourcemessage",
            "translatedMessageTable" => "message"
        ),
    )
);
