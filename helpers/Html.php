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

	public static function numberField($name,$value='',$htmlOptions=array()) {
		self::clientChange('change',$htmlOptions);
		return self::inputField('number',$name,$value,$htmlOptions);
	}

	public static function gravatar($email, $alt="User avatar", $htmlOptions = array()) {
		return self::image("http://www.gravatar.com/avatar/" . strtolower(trim(md5($email))), $alt, array_merge(array(
			"class" => "avatar no-retina-version",
			"title" => $alt
			), $htmlOptions));
	}
}

?>
