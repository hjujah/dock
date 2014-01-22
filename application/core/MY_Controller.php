<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_controller extends CI_Controller {

    public $loggedin; 
    
    public function __construct(){
        parent::__construct();
        // change this !!!
        $this->load->library('session');
		if(!$this->session->userdata('logged_in')){
			redirect(base_url('admin/login/'));
		}
		else{
			$this->loggedin = true;	
		}
    }
    
    public function _remap($method, $params){
        if(method_exists($this, $method)){
            call_user_func_array(array($this,$method), $params);
        }    
        else if(method_exists($this, 'index')){
            call_user_func(array($this,'index'));
        }
        else{
            show_404();
        }
    }   

}


class Public_Controller extends CI_Controller {
	
	protected $menu_items = null;
	
	public function __construct(){
		parent::__construct();
	}
	
	
	function _get_menu_items(){
	
		$this->load->model('gallery_model');
		$this->load->model('brand');
		$brands = $this->brand->get_all();
		$galleries_submenu = $this->gallery_model->get_galleries_submenu_items();
		$niz = array("galleries"=>$galleries_submenu,"brands"=>$brands);
		return $niz;
	}
	
}