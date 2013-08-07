<?php
$this->beginContent(file_exists(Yii::getPathOfAlias("application.views.layouts") . DIRECTORY_SEPARATOR . "mataMain.php") ?
                'application.views.layouts.main' : 'mata.views.layouts.mataMain');
?>

<div id="side-menu-container">
    <div id="side-menu">
        <ul class="menu-item-container">
            <?php
            foreach (MataModuleGroup::model()->with("modules")->findAll() as $moduleGroup):
                $module = Yii::app()->getModule($moduleGroup->modules[0]->Name);

                if ($module == null)
                    throw new CHttpException("Could not find module by id " . $moduleGroup->modules[0]->Name);

                $assetURL = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($module->Name) . DIRECTORY_SEPARATOR . "assets", false, -1, YII_DEBUG);
                if (count($moduleGroup->modules) == 1 && count(Yii::app()->getModule($moduleGroup->modules[0]->Name)->getNav()) == 1):
                    ?>
                    <li class='menu-item'><a href="<?php echo current($module->getNav()) ?>">
                            <?php
                            echo CHtml::image($assetURL . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . str_replace(" ", "-", strtolower(key($module->getNav()))) . "-large-icon.png") .
                            "<span class='label'>" . Yii::t(strtolower($module->Name), $module->Name) . "</span>";
                            ?>
                        </a></li>
                    <?php
                    continue;
                endif;
                ?>

                <li class='menu-item'><a href="javascript:void(0)" data-sub-nav="<?php echo strtolower($moduleGroup->Name) ?>" >
                        <?php
                        echo CHtml::image("/images/icons/" . str_replace(" ", "-", strtolower($moduleGroup->Name)) . "-large-icon.png") .
                        "<span class='label'>" . Yii::t(strtolower($module->Name), $module->Name) . "</span>";
                        ?>

                    </a></li>
                <?php
            endforeach;
            ?>

            <footer>
                <a id="project-name" href='javascript:void(0)' onclick='mata.switchProject()'><?php echo $this->user->project->Name ?></a>
                <a href="/user/logout"> <?php echo Yii::t("mata", "You are") . " " . $this->user->FirstName . " " . $this->user->LastName ?></a>
            </footer>
        </ul>
    </div>

<!--            <li id="side-menu-dashboard"><a onclick="hideSubmenu()" href='/mata/dashboard'><img src='/images/layout/icons/map-icon.png' /></a></li>
            <li id="side-menu-content"><a href='javascript:void(0)' onclick="showSideMenu('content')"><img src='/images/layout/icons/note-icon.png' /></a></li>
            <li id="side-menu-profiles"><a href='javascript:void(0)' onclick="showSideMenu('profiles')"><img src='/images/layout/icons/user-<?php echo $this->user->Sex ?>-icon.png' /></a></li>
            <li id="side-menu-forms"><a href='#'><img src='/images/layout/icons/texting-icon.png' /></a></li>
            <li id="side-menu-settings"><a href='javascript:void(0)' onclick="showSideMenu('settings')"><img src='/images/layout/icons/settings-icon.png' /></a></li>
            <li id="side-menu-help"><a href='#'><img src='/images/layout/icons/loudspeaker-icon.png' /></a></li>
        </ul>-->

    <?php foreach (MataModuleGroup::model()->with("modules")->findAll() as $moduleGroup): ?>
        <div id="sub-menu-<?php echo strtolower($moduleGroup->Name) ?>" class="sub-menu">
            <h2>Accounts</h2>
            <p>Lorem ipsum dolor sit amet, consectuter adupiscig dig.</p>
            <ul class="menu-item-container">
                <?php foreach ($moduleGroup->modules as $module): ?>

                    <?php
                    foreach (Yii::app()->getModule($module->Name)->getNav() as $label => $url):
                        $assetURL = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($module->Name) . DIRECTORY_SEPARATOR . "assets", false, -1, YII_DEBUG);
                        echo "<li class='menu-item'><a href='$url'>" .
                        CHtml::image($assetURL . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . str_replace(" ", "-", strtolower($label)) . "-small-icon.png") .
                        "<span class='label'>" . Yii::t(strtolower($module->Name), $label) .
                        "</span></a></li>";
                    endforeach;
                    ?>
                    <?php
                endforeach;
                ?>

            </ul>
        </div>
        <?php
    endforeach;
    ?>

</div>

<div id='mata-right-pane'>
    <iframe frameborder="0" id='content-container'>
    </iframe>
    <?php echo $content ?>
</div>
<script>

                    $(window).ready(function() {
                        $("#side-menu a").first().trigger("click");
                        // Requires jQuery!

                        jQuery.ajax({
                            url: "http://jira.qi-interactive.com/s/en_UKevdmcy-418945332/812/4/1.2.7/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector-embededjs.js?collectorId=c33a832b",
                            type: "get",
                            cache: true,
                            dataType: "script"
                        });

                    })
                    $("#side-menu-container").find("li a").bind("click", function() {


                        $("#content-container").attr("src", $(this).attr("href"));
                        $(this).parents("ul").first().find(".active").removeClass("active")
                        $(this).parent().first().addClass("active");


                        if ($(this).parents(".sub-menu").length == 0)
                            hideSubmenu()

                        if ($(this).attr("data-sub-nav") != null) {
                            showSideMenu($(this).attr("data-sub-nav"))
                        }

                        return false;
                    })

                    function showSideMenu(section) {
                        hideSubmenu()
                        $("#sub-menu-" + section).addClass("active").transition({
                            left: 100
                        });

                        $("#sub-menu-" + section).show();

                        $("#side-menu-" + section).addClass("active")

                        $("#mata-right-pane").transition({
                            "margin-left": 321
                        });

                        $(window).bind("keyup.sub-menu", function(e) {
                            if (e.keyCode == 27) {
                                hideSubmenu();
                                e.stopPropagation();
                            }

                        });
                    }

                    function hideSubmenu() {
                        $(".sub-menu.active").transition({
                            left: -121
                        }).removeClass("active")

                        $("#mata-right-pane").transition({
                            "margin-left": 100
                        });

                        $(window).unbind("keyup.sub-menu");
                    }
</script>

<?php $this->endContent(); ?>