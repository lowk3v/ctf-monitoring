<?php



require_once("config.php");
function __autoload($classname){
    require_once(LIB_PATH.$classname.".php");
}

new Bootstrap();
