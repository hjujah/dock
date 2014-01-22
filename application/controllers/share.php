<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller {

    /**
        * Index Page for this controller.
        *
        * Maps to the following URL
        * 		http://example.com/index.php/welcome
        *	- or -  
        * 		http://example.com/index.php/welcome/index
        *	- or -
        * Since this controller is set as the default controller in 
        * config/routes.php, it's displayed at http://example.com/
        *
        * So any other public methods not prefixed with an underscore will
        * map to /index.php/welcome/<method_name>
        * @see http://codeigniter.com/user_guide/general/urls.html
        */
        

	public function _remap()
    {
  
	    $uris = $this->uri->segment_array();
	
		$page = $this->uri->segment(2);
		$id = $this->uri->segment(3);
		
		echo $page;
		echo $id;
		
		switch($page){
			case 'news' : 
				$this->load->model('news_model');
				$data['news'] = $this->news_model->get_by_id($id);
				break;
				
			case 'designers' :
				$this->load->model('designers_model');
				$data['designers'] = $this->designers_model->get_by_id($id);
				break;
			
			case 'artists' :
				$this->load->model('artists_model');
				$data['artists'] = $this->artists_model->get_by_id($id);
				break;
		}
		
	    	
		//home
		$this->load->model('home_model');
		$data['home'] = $this->home_model->get_all();	

		//brands
		$this->load->model('brands_model');
		$data['brands'] = $this->brands_model->get_all();
		$data['brands_cz'] = $this->brands_model->get_all_cz();

		
		//$this->load->view('share',$data);
	}	 
       
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */