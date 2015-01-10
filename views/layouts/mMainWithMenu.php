<?php

$this->beginContent(file_exists(Yii::getPathOfAlias("application.views.layouts") . DIRECTORY_SEPARATOR . "mMataMain.php") ?
    'application.views.layouts.mMataMain' : 'mata.views.layouts.mMataMain');
    ?>

    <div id="side-menu-container">
        <div id="side-menu">
            <ul class="menu-item-container">
                <?php
                foreach (MMataModuleGroup::model()->with("modules")->findAll() as $moduleGroup):

                    if (count($moduleGroup->modules) == 0)
                        continue;

                    $module = Yii::app()->getModule($moduleGroup->modules[0]->Name);

                    if ($module == null)
                        throw new CHttpException("Could not find module by id " . $moduleGroup->modules[0]->Name);

                    if ($module->getNav() == false || empty($module->getNav()))
                        continue;

                    $assetURL = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias($module->Name) . DIRECTORY_SEPARATOR . "assets", false, -1, YII_DEBUG);
                    if (count($moduleGroup->modules) == 1 && count(Yii::app()->getModule($moduleGroup->modules[0]->Name)->getNav()) == 1):
                        ?>
                    <li class='menu-item'><a href="<?php echo current($module->getNav()) ?>">
                        <?php

                        echo CHtml::image($assetURL . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "module-large-icon.png") .
                        "<span class='label'>" . Yii::t(strtolower($moduleGroup->Name), Yii::app()->generateLabel($moduleGroup->Name)) . "</span>";
                        ?>
                    </a></li>
                    <?php
                    continue;
                    endif;
                    ?>

                    <li class='menu-item'><a href="javascript:void(0)" data-sub-nav="<?php echo strtolower($moduleGroup->Name) ?>" >
                        <?php
                        echo CHtml::image($assetURL . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "module-large-icon.png") .
                        "<span class='label'>" . Yii::t(strtolower($moduleGroup->Name), Yii::app()->generateLabel($moduleGroup->Name)) . "</span>";
                        ?>

                    </a></li>
                    <?php
                    endforeach;
                    ?>

                    <footer>
                        <?php if (Yii::app()->user->isGuest != true) { ?>
                            <a href="/user/logout"> <?php echo Yii::t("mata", "You are") . " " . Yii::app()->user->username ?></a>
                            <?php } else { ?>

                            <p id="project-name" href='javascript:void(0)'><?php echo Yii::app()->name ?></p>
                            <?php } ?>
                        </footer> 
                    </ul>
                </div>


                <?php foreach (MMataModuleGroup::model()->with("modules")->findAll() as $moduleGroup): ?>
                    <div id="sub-menu-<?php echo strtolower($moduleGroup->Name) ?>" class="sub-menu">
                        <h2>Accounts</h2>
                        <p>Lorem ipsum dolor sit amet, consectuter adupiscig dig.</p>
                        <ul class="menu-item-container">
                            <?php foreach ($moduleGroup->modules as $module): ?>

                                <?php

                                $subNav = Yii::app()->getModule($module->Name)->getNav();

                                if ($subNav == false || empty($subNav))
                                    continue;

                                foreach ($subNav as $label => $url):
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