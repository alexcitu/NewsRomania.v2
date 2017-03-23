<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20-Mar-17
 * Time: 18:34
 */
class Login_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
    }

    public function index()
    {
        session_start();
        $this->load->model('Main_Model');
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
        $this->load->view('Header');
        $this->load->view('Login_view');
        $this->load->view('Footer');
    }
}
?>