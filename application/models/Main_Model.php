<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25-Feb-17
 * Time: 16:39
 */
class Main_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getNews($tip)
    {
        $this->db->select('*')->from('stiri')->from('login')->where('tip', $tip)->where('stiri.email = login.email')->order_by('data', 'desc');
        $query = $this->db->get();
        $records = $query->result();
        foreach ($records as $record)
        {
            $record->nrLike = $this->get_nr_of_likes($record->id);
            $record->nrDislike = $this->get_nr_of_dislikes($record->id);
        }
        return $records;
    }

    public function checkLogin()
    {
        $query = $this->getUserDetailsByUsername($_POST['username']);

        if($query[0]->username == 'admin' && $query[0]->password == md5($_POST['password']))
        {
            $_SESSION['admin'] = 1;
            $_SESSION['reporter'] = 1;
            $_SESSION['username'] = $query[0]->username;
            return $query[0]->username;
        }
        elseif($query[0]->username != 'admin' && $query[0]->password == md5($_POST['password']))
        {
            $_SESSION['admin'] = 0;
            $_SESSION['reporter'] = 1;
            $_SESSION['username'] = $query[0]->username;
            return $query[0]->username;
        }
        else
        {
            return false;
        }
    }

    public function getNewsTypes()
    {
        $this->db->select('tip')->from('stiri')->distinct();
        return $this->db->get()->result();
    }

    public function add_news()
    {
        $query = $this->getUserDetailsByUsername($_SESSION['username']);
        $email = $query[0]->email;
        $titlu = $_POST['titlu'];
        $continut = $_POST['continut'];
        $data = date("Y-m-d");
        $link = $_POST['link'];
        $tip = $_POST['tip'];
        $target_file = basename($_FILES['userfile']["name"]);
        $check_exists = $this->checkNews($titlu);
        $data = array(
                'titlu'    => $titlu,
                'continut' => $continut,
                'data'     => $data,
                'image'    => $target_file,
                'link'     => $link,
                'tip'      => $tip,
                'email'    => $email
        );

        if($check_exists < 1)
        {
            $this->upload_image('userfile');
            $this->db->insert("stiri", $data);

            return $tip;
        }
        else
        {
            return false;
        }
    }

    private function upload_image($image)
    {
        $config['upload_path']   = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 500;
        $config['max_width']     = 1920;
        $config['max_height']    = 1080;
        $this->load->library('upload', $config);
        $this->upload->do_upload($image);
    }

    private function checkNews($titlu)
    {
        $this->db->select('*')->from('stiri')->where('titlu', $titlu);
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function getUserDetailsByUsername($username)
    {
        $this->db->select('*')->from('login')->where('username', $username);
        return $this->db->get()->result();
    }

    private function getUserDetailsByEmail($email)
    {
        $this->db->select('*')->from('login')->where('email', $email);
        return $this->db->get()->result();
    }

    public function registerUser()
    {
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $query = $this->getUserDetailsByEmail($email);

        if(isset($query[0]->email) && $query[0]->email == $email || isset($query[0]->username) && $query[0]->username == $username)
        {
            echo "<script> alert('Username sau Email utilizat!'); </script>";
            redirect('/register', 'refresh');
        }
        else
        {
            $this->db->insert("login", array(
                'username' => $username,
                'password' => $password,
                'nume'     => $nume,
                'prenume'  => $prenume,
                'email'    => $email

            ));
            $_SESSION['reporter'] = 1;
            $_SESSION['username'] = $username;
            echo "<script> alert('Inregistrare cu succes!'); </script>";
            redirect('/home', 'refresh');
        }
    }

    public function searchNews($search, $id = 0)
    {
        if($id == 0)
        {
            $likeSearch = '%' . $search . '%';
            $where = "stiri.email = login.email and (titlu like '$likeSearch' or nume like '$likeSearch' or prenume like '$likeSearch' or continut like '$likeSearch')";
            $this->db->select('*')->from('stiri')->from('login')->where($where)->order_by('data', 'desc');

            $query = $this->db->get();
            $records = $query->result();
            foreach ($records as $record)
            {
                $record->nrLike = $this->get_nr_of_likes($record->id);
                $record->nrDislike = $this->get_nr_of_dislikes($record->id);
            }
            return $records;
        }
        else
        {
            $record = $this->db->select('*')->from('stiri')->from('login')->where('id', $id)->where('stiri.email = login.email');
            $record = $this->db->get();
            if($record->num_rows() == 1)
            {
                $record = $record->result();
                $record[0]->nrLike = $this->get_nr_of_likes($record[0]->id);
                $record[0]->nrDislike = $this->get_nr_of_dislikes($record[0]->id);
                return $record;
            }
            return $record->result();
        }
    }

    public function deleteNews($id)
    {
        $this->db->select('*')->from('stiri')->where('id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            if ($this->db->delete("stiri", "id = ".$id))
            {
                return true;
            }
        }
        return false;
    }

    public function get_news_details($id)
    {
        $this->db->select('*')->from('stiri')->where('id', $id);
        return $this->db->get()->result();
    }

    public function edit_news()
    {
        $query = $this->getUserDetailsByUsername($_SESSION['username']);

        $email = $query[0]->email;
        $titlu = $_POST['titlu'];
        $continut = $_POST['continut'];
        $data = date("Y-m-d");
        $link = $_POST['link'];
        $tip = $_POST['tip'];
        $id = $_POST['id'];

        if(!isset($_FILES['userfile']['name']) || empty($_FILES['userfile']['name']))
        {
            $dataArray = array(
                'titlu'    => $titlu,
                'continut' => $continut,
                'data'     => $data,
                'link'     => $link,
                'tip'      => $tip,
                'email'    => $email
            );
        }
        else
        {
            $target_file = basename($_FILES['userfile']["name"]);
            $dataArray['image'] = $target_file;
        }

        if(isset($dataArray['image']))
        {
            $this->upload_image('userfile');
        }
        $this->db->set($dataArray);
        $this->db->where("id", $id);
        $this->db->update("stiri", $dataArray);

        return $tip;
    }

    public function get_info()
    {
        $rez = $this->getUserDetailsByUsername($_SESSION['username']);
        $data['nume'] = $rez[0]->nume;
        $data['prenume'] = $rez[0]->prenume;
        $data['nrStiri'] = $this->nrOfNewsByEmail($rez[0]->email);
        return $data;
    }

    public function nrOfNewsByEmail($email)
    {
        $this->db->select('COUNT(*) as nrStiri')->from('stiri')->where('email', $email);
        $query = $this->db->get()->result();
        return $query[0]->nrStiri;
    }

    public function like($username, $tip, $id)
    {
        $ok0 = 0;
        $ok1 = 1;
        $query = $this->getUserDetailsByUsername($username);
        $email = $query[0]->email;
        $checkVote = $this->check_vote($id, $email);

        if($checkVote['votat'] == 0)
        {
            $this->db->insert("likeanddislike", array(
                'id' => $id,
                'email' => $email,
                'likeNews'     => $ok1,
                'dislikeNews'  => $ok0,
                'tip'    => $tip
            ));
        }
        elseif($checkVote['votat'] == 1 && $checkVote['like'] == 1)
        {
            $dataArray = array(
                'likeNews'     => $ok0,
                'dislikeNews'  => $ok0
            );
            $this->db->set($dataArray);
            $this->db->where("id", $id)->where('email', $email);
            $this->db->update("likeanddislike", $dataArray);
        }
        elseif($checkVote['votat'] == 1 && $checkVote['like'] == 0)
        {
            $dataArray = array(
                'likeNews'     => $ok1,
                'dislikeNews'  => $ok0
            );
            $this->db->set($dataArray);
            $this->db->where("id", $id)->where('email', $email);
            $this->db->update("likeanddislike", $dataArray);
        }
        return $tip;
    }

    public function dislike($username, $tip, $id)
    {
        $ok0 = 0;
        $ok1 = 1;
        $query = $this->getUserDetailsByUsername($username);
        $email = $query[0]->email;
        $checkVote = $this->check_vote($id, $email);

        if($checkVote['votat'] == 0)
        {
            $this->db->insert("likeanddislike", array(
                'id' => $id,
                'email' => $email,
                'likeNews'     => $ok0,
                'dislikeNews'  => $ok1,
                'tip'    => $tip
            ));
        }
        elseif($checkVote['votat'] == 1 && $checkVote['dislike'] == 1)
        {
            $dataArray = array(
                'likeNews'     => $ok0,
                'dislikeNews'  => $ok0
            );
            $this->db->set($dataArray);
            $this->db->where("id", $id)->where('email', $email);
            $this->db->update("likeanddislike", $dataArray);
        }
        elseif($checkVote['votat'] == 1 && $checkVote['dislike'] == 0)
        {
            $dataArray = array(
                'likeNews'     => $ok0,
                'dislikeNews'  => $ok1
            );
            $this->db->set($dataArray);
            $this->db->where("id", $id)->where('email', $email);
            $this->db->update("likeanddislike", $dataArray);
        }
        return $tip;
    }

    private function check_vote($id, $email)
    {
        $this->db->select('*')->from('likeanddislike')->where('id', $id)->where('email', $email);
        $query = $this->db->get();
        $data['votat'] = $query->num_rows();
        $query = $query->result();
        $data['like'] = $query[0]->likeNews;
        $data['dislike'] = $query[0]->dislikeNews;
        return $data;
    }

    private function get_nr_of_likes($id)
    {
        $this->db->select('COUNT(*) as nrLike')->from('likeanddislike')->where('likeNews = 1')->where('id', $id);
        $query = $this->db->get()->result();
        return $query[0]->nrLike;
    }

    private function get_nr_of_dislikes($id)
    {
        $this->db->select('COUNT(*) as nrDislike')->from('likeanddislike')->where('dislikeNews = 1')->where('id', $id);
        $query = $this->db->get()->result();
        return $query[0]->nrDislike;
    }

    public function get_votes($username, $tip)
    {
        $query = $this->getUserDetailsByUsername($username);
        $email = $query[0]->email;
        $this->db->select('id, likeNews, dislikeNews')->from('likeanddislike')->where('email', $email)->where('tip', $tip);
        return $this->db->get()->result();
    }

    public function getTopNews($tip, $limit)
    {
        $data = null;
        $this->db->select('id, COUNT(*) AS topNews')->from('likeanddislike')->where('tip', $tip)->where('likeNews = 1')->group_by('id')->order_by('topNews', 'desc')->limit($limit);
        $items = $this->db->get()->result();
        foreach ($items as $item)
        {
            $data[] = $this->get_news_details($item->id);
        }
        return $data;
    }
}
?>