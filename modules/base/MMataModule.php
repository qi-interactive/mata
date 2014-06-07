<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MMataModule
 *
 * @author wichura
 */
abstract class MMataModule extends CWebModule {

	private static $_clients;
    public abstract function getNav();

    public static function getClient($className) {
        if(isset(self::$_clients[$className]))
            return self::$_clients[$className];
        else
        {
            $client=self::$_clients[$className]=new $className(null);
            return $client;
        }

    }
}



?>
