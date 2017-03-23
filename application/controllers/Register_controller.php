<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20-Mar-17
 * Time: 18:34
 */
class Register_controller extends CI_Controller
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
        if(isset($_POST) && !empty($_POST))
        {
            $check = $this->Main_Model->registerUser();
        }
        $this->load->view('Header');
        $this->load->view('Register_view');
        $this->load->view('Footer');
    }
}
?>