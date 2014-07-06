<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataActiveRecord
 * Former MataActiveRecord
 * @author wichura
 */
class MMataActiveRecord extends MActiveRecord {

    public function getDbConnection() {
        return Yii::app()->getMataDb();
    }

    public function beforeValidate() {
        $this->manageMataUser();
        return parent::beforeValidate();
    }

    protected function manageMataUser() {

        if ($this->hasAttribute("CreatorMataUserId") &&
            $this->CreatorMataUserId == null && $this->getIsNewRecord()) {
            $this->CreatorMataUserId = Yii::app()->user->getId();
    }

    if ($this->hasAttribute("ModifierMataUserId") && $this->ModifierMataUserId == null)
        $this->ModifierMataUserId = Yii::app()->user->getId();
}

public function getSortableAttributes() {
    return array();
}

public function getLabel() {
    return $this->getPrimaryKey();
}

}

?>
