<?php
/**
 * Created by PhpStorm.
 * User: datlp1
 * Date: 11/9/2018
 * Time: 2:02 PM
 */

class View
{
    public function __construct(){
    }

    public function render($name){
        require_once(VIEW_PATH.'header.php');
        require_once(VIEW_PATH.$name.'.php');
        require_once(VIEW_PATH.'footer.php');
    }
}