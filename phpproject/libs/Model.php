<?php
/**
 * Created by PhpStorm.
 * User: datlp1
 * Date: 11/9/2018
 * Time: 2:01 PM
 */

class Model
{
    public function __construct(){
        // connect to database
        $this -> conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            printf("Connection failed: %s\n", mysqli_connect_error());
            exit();
        }
    }
}