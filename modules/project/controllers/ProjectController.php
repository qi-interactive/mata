<?php

class ProjectController extends MataModuleController {
    
    public function getModel() {
        return Project::model();
    }
    
    public function actionGetProjectsSelector() {
        $this->widget("project.widgets.projectSelector.ProjectSelector");
    }

}
