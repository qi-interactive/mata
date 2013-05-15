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