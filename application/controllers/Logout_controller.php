<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20-Mar-17
 * Time: 19:27
 */
class Logout_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index()
    {
        session_start();
        session_unset();
        session_destroy();
        echo "<script> alert('Te-ai delogat cu succes!'); </script>";
        redirect('/login', 'refresh');
    }
}
?>