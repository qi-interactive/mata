<?php


class MActiveForm extends CActiveForm {

	private $_checkedSettings;

	public function labelEx($model,$attribute,$htmlOptions=array()) {

		if (YII_DEBUG)
			$this->_checkedSettings[DbConfigurableHtml::constructSettingKey($model, $attribute, "visible")] = DbConfigurableHtml::isVisible($model, $attribute);

		return DbConfigurableHtml::activeLabelEx($model,$attribute,$htmlOptions);
	}

	public function textField($model,$attribute,$htmlOptions=array()) {
		return DbConfigurableHtml::activeTextField($model,$attribute,$htmlOptions);
	}

	public function configSummary() {

		if (!YII_DEBUG)
			return;

		foreach ($this->_checkedSettings as $key => $value) {

			echo Html::tag("label", array(), 
				Html::checkbox("", $value, array(
					"class" => "project-setting",
					"data-key" => $key
					)) .  $key
				);
		}

		Yii::app()->clientScript->registerScript('MActiveForm#configSummary','
			$("input.project-setting").on("change", function() {
				console.log($(this).is(":checked"));
				var isChecked = $(this).is(":checked");

				$.ajax("/projectSettings/projectSettings/save", {
					data: {
						"Key" : $(this).attr("data-key"),
						"Value" : isChecked 
					}
				})
	})

		');

	}
}