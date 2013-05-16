<div class="installation-step" >
    <h1>Welcome</h1>
    <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </p>
    <p>
        Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. In hac habitasse platea dictumst.
    </p>
</div>

<div class="installation-step" >
    <h1>Database</h1>
    <p>Assumption is that MySQL database is used - for the time being</p>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'installation-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'DbHost'); ?>
        <?php echo $form->textField($model, 'DbHost', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'DbHost'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'DbName'); ?>
        <?php echo $form->textField($model, 'DbName', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'DbName'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'DbUsername'); ?>
        <?php echo $form->textField($model, 'DbUsername', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'DbUsername'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'DbPassword'); ?>
        <?php echo $form->textField($model, 'DbPassword', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'DbPassword'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Install'); ?>
    </div>


    <?php $this->endWidget(); ?>
</div>

<div class="installation-step" >
    <h1>Summary</h1>
    <p>Summary of data input
    </p>
</div>
<div class="installation-step" >
    <h1>Confirmation</h1>
    <p>It is installed now</p>
</div>