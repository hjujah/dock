<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data extends CI_Controller {

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
		//products, cateogories and brands
		$this->load->model('products_model');
		$data['products'] = $this->products_model->get_all();
		$data['categories'] = $this->products_model->get_all_categories();
		$data['brands'] = $this->products_model->get_all_brands();
		$data['references'] = $this->products_model->get_all_references();
		
		//pages
		$data['pages'] = $this->products_model->get_all_pages();
		
		//news
		$this->load->model('news_model');
		$data['news'] = $this->news_model->get_all();
		
		//home
		$this->load->model('home_model');
		$data['home'] = $this->home_model->get_all();

		$data['json_data'] = $data;
		$this->load->view('json',$data);
	}	 
       
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */