/* NAMESPACES */
window.mata = {};

mata.switchProject = function() {
    mata.dialogBox.renderView("Switch Project", "/project/project/getProjectsSelector", function() {
        var projectId = $(this).attr("data-project-id");
        $.ajax("/mata/home/setProject", {
            data: {
                projectId: projectId
            }
        }).success(function(data) {
            $("#project-name").html(data.Name);
            mata.dialogBox.hide()
        });
    })
};


mata.adaptMainNavBehavior = function() {

    var menuHeight = $("#side-menu .menu-item-container").outerHeight();
    var menuHeightWithoutLabels = null;
    var margin = 250;

    $("#side-menu .menu-item-container > li.menu-item .label").hide();
    setTimeout(function() {
        menuHeightWithoutLabels = $("#side-menu .menu-item-container").outerHeight();
        $("#side-menu .menu-item-container > li.menu-item .label").show();

        $(window).on("resize", function() {

            if (mata._adaptMainNavBehavior)
                clearTimeout(mata._adaptMainNavBehavior )

            mata._adaptMainNavBehavior = setTimeout(function() {
                $("#side-menu .menu-item-container > li.menu-item .label").velocity({
                    height: (menuHeight < $(window).height() - margin) ? 12 : 0,
                });   

                $("#side-menu .menu-item-container > li.menu-item").velocity({
                    "margin-top": (menuHeightWithoutLabels < $(window).height() - margin) ? 35 : 15,
                    "margin-bottom": (menuHeightWithoutLabels < $(window).height() - margin) ? 35 : 15,
                });    
            }, 50)
            
        }).trigger("resize")

    })
}

$(window).load(function() {
    mata.adaptMainNavBehavior()
})

