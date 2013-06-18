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
    }

</style>
<p style="margin-left: 300px">This is admin</p>



<script>
    $(window).ready(function() {


        $("#side-menu-container").sortable({
            "containment": "window",
            "connectWith": "#side-menu-container",
            "z-index": 299999,
            "items": "li",
            start: onDragStart,
            beforeStop: onBeforeDragStop
        });

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
        $(window).bind("mousemove.mataAdmin", function(e) {

            var draggable = $(".ui-sortable-helper");
            var imgDragged = $(".ui-sortable-helper img");
            imgDragged.attr("style", null)
            if (e.pageX < $("#side-menu").width()) {
                imgDragged.map(function(s, el) {
                    el = $(el)
                    el.attr("src", el.attr("src").replace("small", "large"));
                })
                draggable.find("span.label").hide();
                imgDragged.width(32)
            } else {
                imgDragged.map(function(s, el) {
                    el = $(el)
                    el.attr("src", el.attr("src").replace("large", "small"));
                })
                 draggable.find("span.label").show();
                imgDragged.width(16)
            }
        })
    }

    function onBeforeDragStop(e, ui) {
        $(window).unbind("mousemove.mataAdmin");
        ui.helper.find("img, span.label").attr("style", null)
    }
</script>