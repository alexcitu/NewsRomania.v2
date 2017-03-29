<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25-Feb-17
 * Time: 16:31
 */
class Social_controller extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['records'] = $this->Main_Model->getNews($this->uri->segment(1, 'home'));
        $data['topNews'] = $this->Main_Model->getTopNews($this->uri->segment(1, 'home'), NROFNEWS);
        $data['title'] = 'Social News';
        $this->loadView('Main_View', $data);
    }
}
?>