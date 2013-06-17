<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HTML
 *
 * @author wichura
 */
class Html extends CHtml {
    
    
    public static function gravatar($email, $alt="User avatar") {
        return self::image("http://www.gravatar.com/avatar/" . strtolower(trim(md5($email))), $alt, array(
            "class" => "avatar no-retina-version"
        ));
    }
}

?>
