<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExportToCSVBehavior
 *
 * @author wichura
 */
class ExportToCSVBehavior extends CActiveRecordBehavior {

    private $currentLine = array();
    private $retVal = "";

    public function findAllToCSV($csvFileName = null, $condition = array(), $params = array()) {
        
        $rs = $this->getOwner()->findAll();
        
        $relations = $this->getOwner()->getDbCriteria()->with;
        $this->generateHeaders(current($rs), $relations);

        foreach ($rs as $model) {
            foreach ($model as $attribute => $value) {
                $this->addValue($value);
            }
            // relations
            foreach ($relations as $relation) {
                foreach ($model->$relation as $attribute => $value) {
                    $this->addValue($value);
                }
            }
            $this->endLine();
        }
        $csvFileName = $csvFileName != null ? $csvFileName : get_class($this->getOwner());

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$csvFileName");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo $this->retVal;
    }

    private function endLine() {
        $this->retVal .= implode(",", $this->currentLine) . "\n\r";
        $this->currentLine = array();
    }

    private function addValue($value) {
        array_push($this->currentLine, $value);
    }

    private function generateHeaders($model, $relations = array()) {
        foreach ($model as $attribute => $value) {
            $this->addValue($model->getAttributeLabel($attribute));
            // relations
        }

        foreach ($relations as $relation) {
            foreach ($model->$relation->getAttributes() as $attribute => $value) {
                $this->addValue($model->$relation->getAttributeLabel($attribute));
            }
        }

        $this->endLine();
    }

}

?>
