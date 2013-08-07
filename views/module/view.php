<div class="view">

    <h1><?php echo $model->getLabel() ?></h1>
    <?php
    foreach ($model->getAttributes() as $attribute => $value):
        if (!$model->isAttributeSafe($attribute))
            continue;
        ?>

        <div class="row">
            <?php echo CHtml::activeLabel($model, $attribute) ?>
            <?php echo $value ?>
        </div>

        <?php
    endforeach;
    ?>
</div>