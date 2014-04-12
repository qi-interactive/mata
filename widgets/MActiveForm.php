<?php

class MActiveForm extends CActiveForm {


    // like CActiveForm, but you don't need to define the body of form 
    public $model;

    public static $coreTypes=array(
        'text'=>'textField',
        'password'=>'activePasswordField',
        'textarea'=>'activeTextArea',
        'file'=>'activeFileField',
        'radio'=>'activeRadioButton',
        'checkbox'=>'activeCheckBox',
        'listbox'=>'activeListBox',
        'dropdownlist'=>'activeDropDownList',
        'checkboxlist'=>'activeCheckBoxList',
        'radiolist'=>'activeRadioButtonList',
        'url'=>'activeUrlField',
        'email'=>'activeEmailField',
        'number'=>'numberField',
        'range'=>'activeRangeField',
        'date'=>'activeDateField',
        'timestamp' => array(
            "widget" => "zii.widgets.jui.CJuiDatePicker"
            )
        );

    protected function extractType($dbType)
    {
        if(strncmp($dbType,'enum',4)===0)
            return 'text';
        else if(strpos($dbType,'timestamp')!==false || strpos($dbType,'datetime')!==false)
            return 'timestamp';
        else if(strpos($dbType,'float')!==false || strpos($dbType,'double')!==false)
            return 'double';
        else if(strpos($dbType,'bool')!==false)
            return 'boolean';
        else if(strpos($dbType,'int')===0 && strpos($dbType,'unsigned')===false || preg_match('/(bit|tinyint|smallint|mediumint)/',$dbType))
            return 'number';
        else
            return 'text';
    }


    public function run() {

        foreach ($this->model->getAttributes() as $attribute => $value) {

            echo CHtml::openTag("div", array("class" => "row"));

            if (!$this->model->isAttributeSafe($attribute))
                continue;

            echo $this->labelEx($this->model, $attribute);
            echo $this->error($this->model,$attribute); 

            $method=self::$coreTypes[$this->extractType($this->getColumnByNameFromModel($this->model, $attribute)->dbType)];
            
            if (is_array($method))
                $this->widget($method["widget"], array(
                    "model" => $this->model,
                    "attribute" => $attribute
                    ));
            else if(strpos($method,'List')!==false)
                echo "";
                // return $this->$method($this->model, $this->name, $this->items, $this->name);
            else
                echo $this->$method($this->model, $attribute);


            echo CHtml::closeTag("div");

        }

        echo $this->renderSubmitButton();

        parent::run();
    }

    private function renderSubmitButton() {
        echo CHtml::openTag("div", array(
            "class" => "row buttons"
            ));

        echo CHtml::submitButton($this->model->isNewRecord ? 'Create' : 'Save');
        echo CHtml::closeTag("div");
    }

    private function getColumnByNameFromModel($model, $columnName) {
        foreach ($model->getMetaData()->columns as $cn => $column) {
            if ($cn == $columnName)
                return $column;
        } 
    }

}