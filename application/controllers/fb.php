<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb extends Public_Controller {

    function __construct()
    {
        parent::__construct();
 
        $this->load->model('Facebook_model');
    }
	
	function index()
    {
    	/*
        $fb_data = $this->session->userdata('fb_data'); // This array contains all the user FB information

        if((!$fb_data['uid']) or (!$fb_data['me']))
        {
            // If this is a protected section that needs user authentication
            // you can redirect the user somewhere else
            // or take any other action you need
            redirect('login');
        }
        else
        {
        	$data['menudata'] = $this->_get_menu_items(); 
            
            // facebook data
            $data['fb_data'] = $fb_data;

			$this->load->view('facebook_test', $data);
        }
		*/ 
		$data['menudata'] = $this->_get_menu_items(); 
 		$this->load->view('facebook_test', $data);
    }
	 


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */