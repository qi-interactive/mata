<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MataDashboardController
 *
 * @author wichura
 */
class MataAdminController extends MataController {

    public function actionUploadModule() {
        $uploaddir = '/tmp/';
        
        $uploadfile = $uploaddir . basename($_FILES['upload-file']['name']);

        if (move_uploaded_file($_FILES['upload-file']['tmp_name'], $uploadfile)) {
            echo "File is valid, and was successfully uploaded.\n";
        } else {
            echo "Possible file upload attack!\n";
        }

        echo 'Here is some more debugging info:';
        print_r($_FILES);
    }

}

?>
