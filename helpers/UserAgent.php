<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserAgent
 *
 * @author wichura
 */
class UserAgent {

    public static function isAppleTouchDevice() {
        return self::isIPad() || self::isIPhone();
    }

    public static function isIPad() {
        return (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
    }

    public static function isIPhone() {
        return (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
    }

    public static function isMac() {
        return (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'Mac');
    }

}
?>
