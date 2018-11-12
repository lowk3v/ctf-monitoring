<?php
/**
 * Created by PhpStorm.
 * User: kev
 * Date: 10/11/2018
 * Time: 20:30
 */

class Webchallenge_controller extends Controller
{
    function __construct()
    {
        parent :: __construct();
    }

    function parselog()
    {
        if (isset($_POST['id']) && $_POST['id'] >= 0){
            echo json_encode($this->db->getdata($_POST['id']));
        }
    }
}