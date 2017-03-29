<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29-Mar-17
 * Time: 14:58
 */
class Main_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Main_Model');
        session_start();
    }

    public function loadView($fileName = 'Main_view', $data = null)
    {
        if(!file_exists(APPPATH . 'views/' . $fileName . '.php'))
        {
            show_404();
        }

        $this->load->view('Header', $data);
        $this->load->view($fileName, $data);
        $this->load->view('Footer' , $data);
    }

    public function notLoggedIn()
    {
        if((!isset($_SESSION['reporter']) || $_SESSION['reporter'] != 1) && (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1))
        {
            return true;
        }
        return false;
    }
}