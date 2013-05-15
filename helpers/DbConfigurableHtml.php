<?php

/**
 * Description of DbConfigurableHTML
 *
 * @author marcinwiatr
 */
class DbConfigurableHtml {

    public static function categoryList($model, $htmlOptions = array(), $attribute = 'category') {
        if (self::isVisible($model, $attribute) == false)
            return;

        return HTMLHelper::activeCheckBoxListFromGroupedData($model, $attribute, Category::model()->listing($model->getModuleId()), $htmlOptions);
    }

    public static function button($model, $attribute, $label, $htmlOptions = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;

        return HTMLHelper::button($label, $htmlOptions);
    }

    public static function media($model, $attribute, $htmlOptions = array(), $mediaManagerOptions = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;

        return HTMLHelper::media(CHTML::resolveName($model, $attribute), CHTML::resolveValue($model, $attribute), $htmlOptions, $mediaManagerOptions);
    }

    public static function checkbox($model, $attribute, $htmlOptions = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;

        return HTMLHelper::activeCheckBox($model, $attribute, $htmlOptions);
    }

    public static function textArea($model, $attribute) {
        if (self::isVisible($model, $attribute) == false)
            return;

        return HTMLHelper::activeTextArea($model, $attribute);
    }

    public static function activeDropDownList($model, $attribute, $data, $htmlOptions = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;
        return HTMLHelper::activeDropDownList($model, $attribute, $data, $htmlOptions);
    }

    public static function activeHiddenField($model, $attribute, $htmlOptions = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;

        return HTMLHelper::activeHiddenField($model, $attribute, $htmlOptions);
    }

    public static function activeLabelEx($model, $attribute, $htmlOptions = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;

        $customLabel = ProjectSetting::model()->findValueByKey(
                self::constructSettingKey($model, $attribute, "label"));

        if ($customLabel != null)
            $htmlOptions = array_merge($htmlOptions, array(
                "label" => $customLabel
                    ));

        return HTMLHelper::activeLabelEx($model, $attribute, $htmlOptions);
    }

    public static function activeTextField($model, $attribute, $htmlOptions = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;

        return HTMLHelper::activeTextField($model, $attribute, $htmlOptions);
    }

    public function activeWysiwyg($model, $attribute, $wysiwygConfig = array()) {
        if (self::isVisible($model, $attribute) == false)
            return;
        return HTMLHelper::activeWysiwyg($model, $attribute, $wysiwygConfig);
    }

    public static function activeDescription($model, $attribute = null, $htmlOptions = array()) {
        $description = ProjectSetting::model()->findValueByKey(
                self::constructSettingKey($model, $attribute, "description"));

        if ($description != null)
            return HTMLHelper::description($description, $htmlOptions);
    }

    public static function getByKey($key, $defaultValue = "") {
        $value = ProjectSetting::model()->findValueByKey($key);
        return $value != null ? $value : $defaultValue;
    }

    /**
     * We assume controller is not visible unless there is a specific option in the DB.
     * This is not the case with mandatory params which cannot be hidden
     */
    public static function isVisible($model, $attribute) {
        $value = ProjectSetting::model()->findValueByKey(self::constructSettingKey($model, $attribute, "visible"));
        return $value != null && $value == "true";
    }

    /**
     * Creates the key for settings in standard format
     * @param type $model
     * @param type $attribute
     * @param type $setting
     * @return type 
     */
    public static function constructSettingKey($model = null, $attribute = null, $setting = null) {

        $model = $model != null ? "::" . get_class($model) : "";
        $setting = $setting != null ? "::" . $setting : "";
        $attribute = $attribute != null ? "::" . $attribute : "";

        return strtolower(Yii::app()->getController()->id . "::" . Yii::app()->getController()->getAction()->id .
                        $model . $attribute . $setting);
    }

    /**
     * Meta controller
     */
    public static function meta($model, $config = array()) {

        $config = empty($config) == false ? $config :
                ProjectSetting::model()->findValueByKey(self::constructSettingKey($model, "Meta", "config"));

        if ($config == null)
            return null;

        return HTMLHelper::activeMeta($model, $config);
    }

}

?>
