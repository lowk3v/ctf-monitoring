<?php
/**
 * Created by PhpStorm.
 * User: datlp1
 * Date: 11/9/2018
 * Time: 1:50 PM
 */

class Controller{

    public function __construct(){
        $this -> view = new View();
    }

    public function loadModel($modelName){
        $file = MODEL_PATH.$modelName.'_model.php';
        $modelName = ucfirst($modelName).'_model';
        if (file_exists($file)){
            require_once ($file);
            $this -> db = new $modelName();
        }
    }

    public function redirect($controller, $action){
        header("Refresh:0; url = index.php?controllers=$controller&action=$action");
        die();
    }

}



