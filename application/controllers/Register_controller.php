<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 20-Mar-17
 * Time: 18:34
 */
class Register_controller extends Main_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if(isset($_POST) && !empty($_POST))
        {
            $this->Main_Model->registerUser();
        }
        $this->loadView('Register_View');
    }
}
?>