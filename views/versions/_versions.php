
<div class='multioption-container multioption-list'>
    
    
    <?php if (count($versions) == 0) { ?>
    
    <p>No previous versions available</p>
    
    <?php
} else 


foreach ($versions as $version):
    ?>
<div class="multioption-element">
    <a href="<?php echo "/" . $this->getModule()->id . "/" . $this->id . "/update/id/" . $model->Id .  "?rev=" . $version->Revision ?>">

    <?php echo $version->IsPublished ? "Published" : "Drafted" ?> on 
        <?php echo Date::standardDateFormat($version->DateCreated) ?> by 
        <?php echo User::model()->findByPk($version->CreatorMataUserId)->getLabel() ?></a>
    </div>
<?php endforeach; ?>
</div>
