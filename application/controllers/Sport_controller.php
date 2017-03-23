<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25-Feb-17
 * Time: 16:31
 */
class Sport_controller extends CI_Controller
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
        $data['records'] = $this->Main_Model->getNews($this->uri->segment(1, 'home'));
        $data['topNews'] = $this->Main_Model->getTopNews($this->uri->segment(1, 'home'), NROFNEWS);
        $data['title'] = 'Sport News';

        $this->load->view('Header', $data);
        $this->load->view('Main_view', $data);
        $this->load->view('Footer');
    }
}
?>