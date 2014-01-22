<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends Admin_controller{
    
    public function index(){
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
       	$this->load->model('menu_model');
		$menu = $this->menu_model->get_all();
		$data['menu'] = $menu;
		$data['categories'] = $this->menu_model->get_categories();
        //print_r($menu);
        $this->load->view('admin/menu', $data);
    }
    
//------------------------------------------------------------------------------------------------------------------

    public function editDish($id = FALSE)
    {
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
        $id = $this->uri->segment(4);
        if($id && is_numeric($id)){
        	
            $this->load->model('menu_model');
            $dish = $this->menu_model->get_by_id($id);
			$menu = $this->menu_model->get_all();
			$data['menu'] = $menu;
            $data['dish'] = $dish;
			$data['categories'] = $this->menu_model->get_categories();
			//print_r($id);
            $this->load->view('admin/edit_dish', $data);
        }
        else{
            $data['error'] = current_url();
            $this->load->view('admin/error-page',$data);
            return;
        }
    }

//------------------------------------------------------------------------------------------------------------------

}
