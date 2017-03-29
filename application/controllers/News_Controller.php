<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29-Mar-17
 * Time: 16:11
 */
class News_Controller extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_news_view()
    {
        if($this->notLoggedIn())
        {
            echo "<script> alert('Nu esti logat deci nu poti adauga stiri'); </script>";
            redirect('/login', 'refresh');
        }
        $data['title'] = 'Add News';
        $data['types'] = $this->Main_Model->getNewsTypes();
        $this->loadView('News_add', $data);
    }

    public function add_news()
    {
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
        if($this->notLoggedIn())
        {
            echo "<script> alert('Nu esti logat deci nu poti edita stiri'); </script>";
            redirect('/login', 'refresh');
        }
        $data['id'] = $this->uri->segment(3);
        $data['title'] = 'Edit News';
        $data['types'] = $this->Main_Model->getNewsTypes();
        $data['newsDetails'] = $this->Main_Model->get_news_details($data['id']);
        $this->loadView('News_edit', $data);
    }

    public function update_news()
    {
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
        $data = $this->Main_Model->get_info();
        echo '<p>Nume utilizator: '. $data['nume'] .' </p>';
        echo '<p>Prenume utilizator: '. $data['prenume'] .' </p>';
        echo '<p>Numar stiri adaugate: '. $data['nrStiri'] .' </p>';
    }

    public function like()
    {
        $ok = $this->Main_Model->like($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
        redirect('/'.$ok, 'refresh');
    }

    public function dislike()
    {
        $ok = $this->Main_Model->dislike($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
        redirect('/'.$ok, 'refresh');
    }

    public function get_votes()
    {
        $data = array();
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