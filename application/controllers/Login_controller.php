<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20-Mar-17
 * Time: 18:34
 */
class Login_controller extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $check = false;
        if(isset($_POST) && !empty($_POST))
        {
            $check = $this->Main_Model->checkLogin();
        }
        if($check != false)
        {
            echo "<script> alert('Te-ai logat cu succes!'); </script>";
            redirect('/home', 'refresh');
        }
        $this->loadView('Login_View');
    }
}
?>