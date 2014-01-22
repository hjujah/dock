<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sorting extends CI_Controller {

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
		$data['page'] = $this->uri->segment(2);
		  
    	//news	
    	$this->load->model('news_model');
		$data['news'] = $this->news_model->get_all();	
		$data['news_cz'] = $this->news_model->get_all_cz();	
		
		//works
		$this->load->model('work_model');
		$data['works'] = $this->work_model->get_all();	
		$data['works_cz'] = $this->work_model->get_all_cz();	
		
		//ENGLISH HOME
		$this->load->model('home_model');
		$home = $this->home_model->get_all();
		$works = $this->work_model->get_all_home();
		$news = $this->news_model->get_all_home();	
		
		$data['home'] = array();		
		foreach($works as $work){
			array_push($data['home'],$work);
		}
		if(count($news)>0){
			foreach($news as $new){
				array_push($data['home'],$new);
			}
		}
		foreach($home as $new){
			array_push($data['home'],$new);
		}
		

		//CZECH HOME
		$works_cz = $this->work_model->get_all_home_cz();
		$news_cz = $this->news_model->get_all_home_cz();	
		$home_cz = $this->home_model->get_all_cz();
		$data['home_cz'] = array();		
		foreach($works_cz as $work){
			array_push($data['home_cz'],$work);
		}
		if(count($news_cz)>0){
			foreach($news_cz as $new){
				array_push($data['home_cz'],$new);
			}
		}
		foreach($home_cz as $new){
			array_push($data['home_cz'],$new);
		}
		

						
		
		if($data['page']=='works'){
			$data['home'] = $data['works'];
			uasort($data['home'], function ($i, $j) {
			    $a = $i->order;
			    $b = $j->order;
			    if ($a == $b) return 0;
			    elseif ($a > $b) return 1;
			    else return -1;
			});
		}elseif($data['page']=='news'){
			$data['home'] = $data['news'];
			uasort($data['home'], function ($i, $j) {
			    $a = $i->order;
			    $b = $j->order;
			    if ($a == $b) return 0;
			    elseif ($a > $b) return 1;
			    else return -1;
			});
		}elseif($data['page']=='home'){
			uasort($data['home'], function ($i, $j) {
			    $a = $i->home;
			    $b = $j->home;
			    if ($a == $b) return 0;
			    elseif ($a > $b) return 1;
			    else return -1;
			});
		}else{
			$projects = $data['works'];
			$param = urldecode($data['page']);		
			$callback = function($projects) use ($param) {
				if(empty($param) || $param=="all") {
					return $projects; break;
				}else{
					return ($projects->category[0]==$param);
				}
			};
			$data['home'] = array_filter($projects, $callback);
			
			uasort($data['home'], function ($i, $j) {
			    $a = $i->category_order;
			    $b = $j->category_order;
			    if ($a == $b) return 0;
			    elseif ($a > $b) return 1;
			    else return -1;
			});
			
			$data['page'] = $param;
		}
		
		
				
		$categories = array();
		foreach($data['works'] as $work){
			foreach($work->category as $cat){
				array_push($categories,$cat);
			}			
		}
		$data['categories'] = array_unique($categories);
	
		$this->load->view('sorting',$data);
	}	 
       
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */