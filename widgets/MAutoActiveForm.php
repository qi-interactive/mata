<?php

Yii::import("mata.widgets.MActiveForm");

class MAutoActiveForm extends MActiveForm {

    // like CActiveForm, but you don't need to define the body of form 
    public $model;

    public $fields = array();

    public $excludeFields = array();

    public static $coreTypes=array(
        'text'=>'textField',
        'password'=>'activePasswordField',
        'textarea'=>'textArea',
        'file'=>'activeFileField',
        'radio'=>'activeRadioButton',
        'checkbox'=>'activeCheckBox',
        'listbox'=>'activeListBox',
        'dropdownlist'=>'dropDownList',
        'checkboxlist'=>'activeCheckBoxList',
        'radiolist'=>'activeRadioButtonList',
        'url'=>'activeUrlField',
        'email'=>'activeEmailField',
        'number'=>'numberField',
        'range'=>'activeRangeField',
        'timestamp' => array(
            "widget" => "zii.widgets.jui.CJuiDatePicker"
            )
        );

    protected function extractType($dbType) {
        if(strncmp($dbType,'enum',4)===0)
            return 'dropdownlist';
        else if(strpos($dbType,'timestamp')!==false || strpos($dbType,'datetime')!==false || strpos($dbType,'date')!==false)
            return 'timestamp';
        else if(strpos($dbType,'float')!==false || strpos($dbType,'double')!==false)
            return 'double';
        else if(strpos($dbType,'bool')!==false)
            return 'boolean';
        else if(strpos($dbType,'text')!==false)
            return 'textarea';
        else if(strpos($dbType,'int')===0 && strpos($dbType,'unsigned')===false || preg_match('/(bit|tinyint|smallint|mediumint)/',$dbType))
            return 'number';
        else
            return 'text';
    }

    public function run() {


       foreach ($this->model->attributeNames() as $attribute) {

           if (in_array($attribute, $this->excludeFields)) continue;

           $preComputedFormElement = null;
           echo CHtml::openTag("div", array("class" => "row"));

           if (!$this->model->isAttributeSafe($attribute))
               continue;

           echo $this->labelEx($this->model, $attribute);
           echo $this->error($this->model,$attribute); 

           if ($this->isForeignKey($attribute)) {

               $relationName = null;

               foreach($this->model->relations() as $relationName => $relationOptions) {

                   $relationSchema = $this->model->getMetaData()->relations[$relationName];

                   if ($relationSchema->foreignKey == $attribute) {

                       if (is_a($relationSchema, "CBelongsToRelation") || is_a($relationSchema, "CHasOneRelation")) {
                           $model = $relationSchema->className;

                         // Update Id to primaryKey, Label stays
                           $preComputedFormElement =  $this->dropDownList($this->model, $attribute, CHtml::listData($model::model()->findAll(), "Id", "Label"));
                           break;
     // One value to be selected
                       } else {
     // multiple value selector 
                       }
                   }
               }
           }


           if (array_key_exists($attribute, $this->fields)) {
              $method = $this->fields[$attribute];
          } else {
           $method=self::$coreTypes[$this->extractType($this->getColumnByNameFromModel($this->model, $attribute)->dbType)];            
       }

       if ($preComputedFormElement != null) {
           echo $preComputedFormElement;
       } else {

           if (is_array($method))
               $this->widget($method["widget"], array_merge(array(
                   "model" => $this->model,
                   "attribute" => $attribute
                   ), isset($method["config"]) ? $method["config"] : array()));
           else if(strpos($method,'List')!==false)
               echo $this->$method($this->model, $attribute, $this->getValuesForEnum($this->model, $attribute));
           else
               echo $this->$method($this->model, $attribute);

       }

       echo CHtml::closeTag("div");

   }

   echo $this->renderSubmitButton();

   parent::run();
}


private function isForeignKey($attribute) {
    return $this->getColumnByNameFromModel($this->model, $attribute)->isForeignKey;
}


private function renderSubmitButton() {
    echo CHtml::openTag("div", array(
        "class" => "row buttons"
        ));

    echo CHtml::submitButton($this->model->isNewRecord ? 'Create' : 'Save');
    echo CHtml::closeTag("div");
}

private function getValuesForEnum($model, $columnName) {
    $column = $this->getColumnByNameFromModel($model, $columnName);

        // Looks like enum('United Kingdom','United States')
    $dbType = $column->dbType;

    preg_match("/enum\((.*)\)/", $dbType, $values);


        // Now we have array(United Kingdom, United States);
    $values = preg_replace("/\'/", "", $values[1]);

    $values =  explode(",", $values);

        // now we end up having (array(United Kingdom => United States => United States))
    return array_combine($values, $values);
}

private function getColumnByNameFromModel($model, $columnName) {
    foreach ($model->getMetaData()->columns as $cn => $column) {
        if ($cn == $columnName)
            return $column;
    } 
}

}