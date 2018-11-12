<?php
/**
 * Created by PhpStorm.
 * User: datlp1
 * Date: 11/9/2018
 * Time: 1:21 PM
 */

class Bootstrap{

    public function __construct(){
        // Default: ?controller=dashboard&action=index
        (isset($_GET['controller']))
            ?	$controller_url = ucfirst($_GET['controller'])
            :	$controller_url = ucfirst("dashboard");
        (isset($_GET['action']))
            ?	$action_url = $_GET['action']
            :	$action_url = "index";

        $file = CONTROLLER_PATH.$controller_url."_controller.php";
        if (file_exists($file)){
            // load controllers
            require_once($file);
            $controller = $controller_url."_controller";
            $controller = new $controller();

            if (method_exists($controller, $action_url)){
                // load actions and models
                $controller -> loadmodel($controller_url);
                $controller -> $action_url();
            }else{
                $this -> error();
            }
        }else{
            $this -> error();
        }
    }

    function error(){
        echo "ERROR";
    }
}