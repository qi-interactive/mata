<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataInstallerForm
 *
 * @author wichura
 */
class MataInstallerForm extends CFormModel {

    public $DbName;
    public $DbHost;
    public $DbUsername;
    public $DbPassword;

    public function rules() {
        return array(
// username and password are required
            array('DbName, DbHost, DbUsername, DbPassword', 'required'),
            // password needs to be authenticated
            array('DbName, DbHost, DbUsername, DbPassword', 'checkDbConnection', 'message' => "s"),
        );
    }

    public function checkDbConnection($attribute, $params) {
        if (!$this->hasErrors()) {
            // suppress warning from PHP - we want to catch them
            error_reporting(E_ALL ^ E_WARNING);

            try {
                $connection = new CDbConnection("mysql:host=$this->DbHost;dbname=$this->DbName", $this->DbUsername, $this->DbPassword);
                $connection->active = true;
            } catch (Exception $e) {
                $this->addError(null, "Could not connect to the db - please verify the details: " . $e->getMessage());
            }
        }
    }

}

?>
