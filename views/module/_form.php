<div class="form">

    <?php
    $this->widget('mata.widgets.MActiveForm', array(
        'id' => "client-" . strtolower(get_class($model)),
        "model" => $model,
        'enableAjaxValidation' => true,
        ));

        ?>

    </div>