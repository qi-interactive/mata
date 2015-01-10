<?php
$pk = is_array($data->getPrimaryKey()) ? http_build_query($data->getPrimaryKey()) : $data->getPrimaryKey();
?>

<div class="list-view-item">
    <a href="<?php echo Yii::app()->controller->id ?>/update/id/<?php echo $pk ?>">
        <div style="width: 835px" class="column">
            <h4 class="data-label"><?php echo $data->getLabel() ?></h4>
            <hr />

            <ul class="horizontal">
                <?php
                foreach ($widget->sortableAttributes as $attribute) {

                    // Handle relations
                    if (stripos($attribute, ".") > - 1) {
                        $args = explode(".", $attribute);
                        $data = $data->$args[0];
                        $attribute = $args[1];
                    }

                    $value = $data->$attribute;

                    if (preg_match("/^\d\d\d\d-(\d)?\d-(\d)?\d \d\d:\d\d:\d\d$/", $value))
                        $value = Date::standardDateFormat($value);

                    if ($value != null)
                        echo CHtml::tag("li", array(), $data->getAttributeLabel($attribute) . ": " . $value);
                }
                ?>       


            </ul>

        </div>
    </a>
    <div class='actions hidden'>
        <a class='delete' href='<?php echo Yii::app()->controller->id ?>/delete/id/<?php echo $pk ?>'>&nbsp;</a>
    </div>
</div>