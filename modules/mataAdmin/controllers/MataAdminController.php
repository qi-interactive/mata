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

    public function actionInstallDummy() {
        $this->install("/tmp/contentblock.mata");
    }

    public function actionIndex() {

        $configFolder = Yii::getPathOfAlias("application.config");
        $this->setData("modules", MataModule::model()->findAll());
        
        parent::actionIndex();
    }

    public function actionUploadModule() {
        $uploaddir = '/tmp/';

        $uploadfile = $uploaddir . basename($_FILES['upload-file']['name']);

        if (move_uploaded_file($_FILES['upload-file']['tmp_name'], $uploadfile)) {
            echo "File is valid, and was successfully uploaded.\n";

            $this->install($uploadfile);
        } else {
            echo "Possible file upload attack!\n";
        }

//        echo 'Here is some more debugging info:';
//        print_r($_FILES);
    }

    private function install($packageFile) {

        try {
            if ($this->moveToApplication($this->uncompress($packageFile) . DIRECTORY_SEPARATOR . basename($packageFile, ".mata"), Yii::getPathOfAlias("application.modules") . DIRECTORY_SEPARATOR . basename($packageFile, ".mata")) == false)
                throw new CHttpException(500, "Copy from package tmp location to application failed");

            $this->updateMataConfigFile(basename($packageFile, ".mata"));
        } catch (Exception $e) {
            throw new CHttpException(500, "Installation failed: " . $e->getMessage());
        }
    }

    // TODO problem is that i cannot execute scripts as sudo 

    private function uncompress($packageFile) {

        $zip = new ZipArchive;
        $res = $zip->open($packageFile);
        if ($res !== TRUE)
            throw new CHttpException(500, "Could not access file at location: " . $file);

        $tmpFolder = '/tmp/' . basename($packageFile) . "-" . time();

        $zip->extractTo($tmpFolder);
        $zip->close();

        return $tmpFolder;
    }

    private function moveToApplication($source, $dest) {

        if (file_exists($dest) == false) {
            if (!@mkdir($dest))
                throw new CHttpException(500, "Could not create folder: " . $dest);
        } else {
            if ($this->deleteDirectory($dest) == false)
                throw new CHttpException(500, "Could not remove old version of module: " . $dest);
        }
        return rename($source, $dest);
    }

    private function updateMataConfigFile($moduleName) {
        $configFile = Yii::getPathOfAlias("application.config") . DIRECTORY_SEPARATOR . "dev.php";

        $config = require($configFile);
        
        
        $config = CMap::mergeArray($config, array(
            "modules" => array(
                $moduleName
            )
        ));
        
        
//        file_put_contents($configFile . ".bak", print_r($config, 1));
//         ob_start();
//        echo "<pre>";
//        
//        print_r($config);
//        
//        $pngString = ob_get_contents();
//        ob_end_clean();
         echo "<pre>";
        print_r($config);
    }

    function deleteDirectory($dir) {
        if (!file_exists($dir))
            return true;
        if (!is_dir($dir) || is_link($dir))
            return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..')
                continue;
            if (!$this->deleteDirectory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!$this->deleteDirectory($dir . "/" . $item))
                    return false;
            };
        }
        return rmdir($dir);
    }

}

?>
