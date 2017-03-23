<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25-Feb-17
 * Time: 16:31
 */
class Home_controller extends CI_Controller
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
        $data['title'] = 'News Romania';
        $this->load->view('Header', $data);
        $this->load->view('Main_view', $data);
        $this->load->view('Footer');
    }

    public function add_news_view()
    {
        session_start();
        $this->load->model('Main_Model');
        if((!isset($_SESSION['reporter']) || $_SESSION['reporter'] != 1) && (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1))
        {
            echo "<script> alert('Nu esti logat deci nu poti adauga stiri'); </script>";
            redirect('/login', 'refresh');
        }
        $data['title'] = 'Add News';
        $data['types'] = $this->Main_Model->getNewsTypes();
        $this->load->view('Header', $data);
        $this->load->view('News_add', $data);
        $this->load->view('Footer');
    }

    public function add_news()
    {
        session_start();
        $this->load->model('Main_Model');
        $ok = $this->Main_Model->add_news();
        if($ok != false)
        {
            echo "<script> alert('Stire adaugata cu succes!'); </script>";
            redirect('/'.$ok, 'refresh');
        }
        else
        {
            echo "<script> alert('Stirea exista deja!'); </script>";
            redirect('/news/add_view', 'refresh');
        }
    }

    public function delete_news()
    {
        $this->load->model('Main_Model');
        $this->Main_Model->deleteNews($this->input->post('sterge'));
        if($_SERVER['HTTP_REFERER'] == base_url())
        {
            redirect('/', 'refresh');
        }
        else
        {
            redirect(basename($_SERVER['HTTP_REFERER']).PHP_EOL, 'refresh');
        }
    }

    public function edit_news_view()
    {
        session_start();
        $this->load->model('Main_Model');
        if((!isset($_SESSION['reporter']) || $_SESSION['reporter'] != 1) && (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1))
        {
            echo "<script> alert('Nu esti logat deci nu poti edita stiri'); </script>";
            redirect('/login', 'refresh');
        }
        $data['id'] = $this->uri->segment(3);
        $data['title'] = 'Edit News';
        $data['types'] = $this->Main_Model->getNewsTypes();
        $data['newsDetails'] = $this->Main_Model->get_news_details($data['id']);
        $this->load->view('Header', $data);
        $this->load->view('News_edit', $data);
        $this->load->view('Footer');
    }

    public function update_news()
    {
        session_start();
        $this->load->model('Main_Model');
        $ok = $this->Main_Model->edit_news();
        if($ok != false)
        {
            echo "<script> alert('Stire editata cu succes!'); </script>";
            redirect('/'.$ok, 'refresh');
        }
        else
        {
            echo "<script> alert('Stirea exista deja!'); </script>";
            redirect('/news/add_view', 'refresh');
        }
    }

    public function get_info()
    {
        session_start();
        $this->load->model('Main_Model');
        $data = $this->Main_Model->get_info();

        echo '<p>Nume utilizator: '. $data['nume'] .' </p>';
        echo '<p>Prenume utilizator: '. $data['prenume'] .' </p>';
        echo '<p>Numar stiri adaugate: '. $data['nrStiri'] .' </p>';
    }

    public function like()
    {
        $this->load->model('Main_Model');
        $ok = $this->Main_Model->like($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
        redirect('/'.$ok, 'refresh');
    }

    public function dislike()
    {
        $this->load->model('Main_Model');
        $ok = $this->Main_Model->dislike($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
        redirect('/'.$ok, 'refresh');
    }

    public function get_votes(){
        session_start();
        $this->load->model('Main_Model');
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != base_url())
        {
            $var = basename($_SERVER['HTTP_REFERER']).PHP_EOL;
        }
        else
        {
            $var = 'home';
        }
        $var = preg_replace("/[\n\r]/", "", $var);

        $items = $this->Main_Model->get_votes($_SESSION['username'], $var);
        foreach ($items as $item) {
            $aux['likeNews'] = $item->likeNews;
            $aux['dislikeNews'] = $item->dislikeNews;
            $aux['id'] = $item->id;
            $data[] = $aux;
        }
        echo json_encode($data);
    }
}
?>