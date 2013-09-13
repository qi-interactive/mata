<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style>
    #side-menu, .sub-menu {
        z-index:auto;
    }

    #side-menu .menu-item img {
        width: 32px;
    }

    .sub-menu .menu-item img {
        width: 16px;
    }

    .menu-item-container {
        min-height: 20px;
    }

    .ui-sortable-helper {
        border: none !important;
        width: 220px !important;
        height: 16px !important;
        line-height: 32px !important;
        vertical-align: middle !important;
    }

    #content-container {
        display: none;
    }

    #mata-right-pane {
        padding: 0px 50px;
    }
</style>

<!-- The file upload form used as target for the file upload widget -->
<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
    <!-- Redirect browsers with JavaScript disabled to the origin page -->
    <noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
    <div class="row fileupload-buttonbar">
        <!-- The global progress information -->
        <div class="span5 fileupload-progress fade">
            <!-- The global progress bar -->
            <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                <div class="bar" style="width:0%;"></div>
            </div>
            <!-- The extended global progress information -->
            <div class="progress-extended">&nbsp;</div>
        </div>
    </div>
    <!-- The loading indicator is shown during file processing -->
    <div class="fileupload-loading"></div>
    <br>
    <!-- The table listing the files available for upload/download -->
    <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
</form>

<?php
$this->widget('mata.modules.media.widgets.FileUploader', array());
?>

<form id="upload-file-form" action="/mataAdmin/mataAdmin/uploadModule">
    <label>Install new module</label>
    <input name="upload-file" id="file-input" type="file" />
</form>


<?php
if (!is_writable(Yii::getPathOfAlias("application.config")))
    echo "<p class='error'>Config folder is not writable</p>";
?>

<?php
if (!is_writable(Yii::getPathOfAlias("application.modules")))
    echo "<p class='error'>Modules folder is not writable</p>";
?>



<div id="mata-modules">

    <h1>Installed modules</h1>
    <?php
    
    echo json_encode(array(
            'connectionString' => 'mysql:host=37.123.117.163;dbname=manage.qi-interactive.com',
            'emulatePrepare' => true,
            'username' => 'qi',
            'password' => 'CHcxjvLs',
            'charset' => 'utf8',
            'enableParamLogging' => true
        ));
    foreach ($modules as $module):
        $config = json_decode($module->Config, true);
        ?>
        <h2><?php echo $module->Name ?></h2>

        <?php
        if ($config != null):
            foreach ($config as $key => $value):
                ?>

            <label><?php echo $key ?></label>
            <input type="text" value="<?php echo $value ?>"  />

                <?php
            endforeach;
        endif;
        ?>

    <?php endforeach; ?>



</div>

<script>


    $('#file-input').change(function() {
        var file = this.files[0];
        name = file.name;
        size = file.size;
        type = file.type;

        var formData = new FormData($('#upload-file-form')[0]);
        $.ajax({
            url: '/mataAdmin/mataAdmin/uploadModule', //server script to process data
            type: 'POST',
            xhr: function() {  // custom xhr
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // if upload property exists
                    myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // progressbar
                }
                return myXhr;
            },
            //Ajax events
            success: completeHandler = function(data) {
//                /*
//                 * workaround for crome browser // delete the fakepath
//                 */
//                if (navigator.userAgent.indexOf('Chrome')) {
//                    var catchFile = $(":file").val().replace(/C:\\fakepath\\/i, '');
//                }
//                else {
//                    var catchFile = $(":file").val();
//                }
//                var writeFile = $(":file");
//
//                writeFile.html(writer(catchFile));
//
//                $("*setIdOfImageInHiddenInput*").val(data.logo_id);

            },
            error: errorHandler = function(e) {
                console.log(e)
            },
            // Form data
            data: formData,
            //Options to tell JQuery not to process data or worry about content-type
            cache: false,
            contentType: false,
            processData: false
        }, 'json');
    });

    function progressHandlingFunction(a) {
        console.log(a)
    }

    $(window).ready(function() {


        $("#side-menu-container, .menu-item-container").sortable({
            "containment": "window",
            "connectWith": ".menu-item-container",
            "z-index": 299999,
            "items": "li",
            tolerance: "pointer",
            start: onDragStart,
            beforeStop: onBeforeDragStop
        });

//        $(".menu-item-container").sortable({
//            "connectWith": "#side-menu-container",
//             "z-index": 299999,
//            "items": "li",
//            start: onDragStart,
//            beforeStop: onBeforeDragStop
//        })
//        $("#side-menu").sortable({
//            "containment": "window",
//            "connectWith": ".sub-menu",
//            "z-index": 299999,
//            "items": "li",
//            start: onDragStart,
//            stop: onDragStop
//        });
    })

    function onDragStart() {

        var mataGroupDrag = null;

        $(".ui-sortable-helper img").data("mataGroupDrag", null)
        $(window).bind("mousemove.mataAdmin", function(e) {

            var draggable = $(".ui-sortable-helper");
            var imgDragged = $(".ui-sortable-helper img");

            if (mataGroupDrag == null)
                imgDragged.attr("style", null)

            if (e.pageX < $("#side-menu").width() && mataGroupDrag !== true) {

                mataGroupDrag = true
                imgDragged.map(function(s, el) {
                    el = $(el)
                    el.attr("src", el.attr("src").replace("small", "large"));
                })
                draggable.find("span.label").hide();
                imgDragged.stop().transit({
                    width: 32
                })
            } else if (e.pageX > $("#side-menu").width() && mataGroupDrag !== false) {
                console.log(33)
                mataGroupDrag = false
                imgDragged.map(function(s, el) {
                    el = $(el)
                    el.attr("src", el.attr("src").replace("large", "small"));
                })
                draggable.find("span.label").show();
                imgDragged.stop().transit({
                    width: 16
                })
            }
        })
    }

    function onBeforeDragStop(e, ui) {
        $(window).unbind("mousemove.mataAdmin");
        ui.helper.find("img, span.label").attr("style", null)
    }
</script>

<div>