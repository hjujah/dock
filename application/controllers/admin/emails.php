<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Emails extends Admin_controller{
    
    public function index(){
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
        $this->load->model('fbuser');
		$emails = $this->fbuser->get_all();
        if($emails){
            $data['emails'] = array('success'=>true, 'emails'=>$emails);
        }
        else{
            $data['emails'] = array('success'=>false);
        }
        $this->load->view('admin/emails',$data);
    }
}
