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
        'mata.modules.project.models.*'
    ),
    'modules' => array(
        'user' => array(
            'class' => "mata.modules.user.UserModule",
            'hash' => 'sha1',
            'sendActivationMail' => true,
            'activeAfterRegister' => false,
            'autoLogin' => true,
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
        'matadb' => array(
        ),
        'clientScript' => array(
            'packages' => array(
                'bbq' => array(
                    'basePath' => "webroot.js.lib",
                    'js' => array('jquery.ba-bbq.js'),
                    'coreScriptPosition' => CClientScript::POS_HEAD
                )
            )
        )
    )
);
