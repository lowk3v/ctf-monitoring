<?php
/**
 * Created by PhpStorm.
 * User: datlp1
 * Date: 11/9/2018
 * Time: 1:54 PM
 */

class Dashboard_controller extends Controller
{
    public function __construct(){
        parent :: __construct();
    }

    public function index(){
        $this -> view -> render("index");
    }
}