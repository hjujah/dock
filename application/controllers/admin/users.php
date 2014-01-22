<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Users extends Admin_controller{
    
    
    public function index(){
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
        $this->load->model('user');
        $users = $this->user->get_all();
        if($users){
            $data['users'] = array('success'=>true, 'users'=>$users);
        }
        else{
            $data['users'] = array('success'=>false);
        }
        $this->load->view('admin/users',$data);
    }
    
//------------------------------------------------------------------------------------------------------------------

    public function addUser(){
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
        	$this->load->view('admin/addUser');    
	}
        
//------------------------------------------------------------------------------------------------------------------

    public function editUser($id){
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
        if($this->session->userdata('privilegies') == 1 || $this->session->userdata('user_id') == $id){
        $user;  
        if($id && is_numeric($id)){
            $this->load->model('user');
            $user = $this->user->get_by_id($id);
        }                    
        $data['user'] = $user;
        $this->load->view('admin/editUser', $data);
		}
		else{
			$data['heading'] = 'Access error';
			$data['body'] = 'Access is denied for your level of privilegies.';
			$this->load->view('admin/error-page', $data);
		}  
    }
    
//------------------------------------------------------------------------------------------------------------------

    public function deleteUser($id){
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
    	if($this->session->userdata('privilegies') == 1){ 
        	$user;
	        if($id && is_numeric($id)){
	            $this->load->model('user');
	            $user = $this->user->get_by_id($id);   
	        }
	        $data['user'] = $user;         
	        $this->load->view('admin/deleteUser', $data);
		}
		else{
			$data['heading'] = 'Access error';
			$data['body'] = 'Access is denied for your level of privilegies.';
			$this->load->view('admin/error-page', $data);
		} 
    }

//------------------------------------------------------------------------------------------------------------------
}
