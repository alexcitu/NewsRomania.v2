<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25-Feb-17
 * Time: 16:31
 */
class Search_controller extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if($this->uri->segment(2) == false)
        {
            $data['records'] = $this->Main_Model->searchNews(addslashes($this->input->post('search_news')));
        }
        else
        {
            $data['records'] = $this->Main_Model->searchNews('a', $this->uri->segment(2));
        }

        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != base_url())
        {
            $var = basename($_SERVER['HTTP_REFERER']).PHP_EOL;
        }
        else
        {
            $var = 'home';
        }
        $var = preg_replace("/[\n\r]/", "", $var);

        $data['topNews'] = $this->Main_Model->getTopNews($var, NROFNEWS);
        $data['title'] = 'Search News';
        $this->loadView('Main_View', $data);
    }
}
?>