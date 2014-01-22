<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Booking extends Admin_controller{
    
    public function index(){
		
    }
	
	public function _remap(){
		$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
        $id = $this->uri->segment(3);
        if(!empty($id) && is_numeric($id)){   			
			 $data['id'] = $id;
       		 $this->load->view('admin/booking',$data);
        }  
    }


}
