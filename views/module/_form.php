<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'project-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <?php
        foreach ($model->getAttributes() as $attribute => $value):
            if (!$model->isAttributeSafe($attribute))
                continue;
            ?>

            <div class="row">
                <?php echo $form->labelEx($model, $attribute); ?>
                <?php // TODO Assumed textfield, how can we differentiate ?>
                <?php echo $form->textField($model, $attribute); ?>
                <?php echo $form->error($model, $attribute); ?>
            </div>

            <?php
        endforeach;
        ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->