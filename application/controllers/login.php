<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
    
    public function index(){
        $this->load->view('admin/index');
    }
	
	public function login_ajax(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		if(empty($username) || empty($password)){
			$data['json_data'] = array('success' => false, 'error' => 'Invalid parameters.');
			$this->load->view('json', $data);
		}
		if($user = $this->_check_user($username, $password)){
			$this->load->library('session');
			$this->session->set_userdata(array('user_id' => $user->id, 'username' => $user->username, 'display_name' => $user->display_name, 'logged_in' => TRUE));	
		}
		else{
			$data['json_data'] = array('success' => false, 'error' => 'Username or/and password are incorrect.');
			$this->load->view('json', $data);	
		}
    }
	
	public function logout_ajax(){
		if($this->session->userdata('logged_in')){
			$this->load->library('session');
			$this->session->sess_destroy();
			redirect('admin/login', 'refresh');	
		}
		else{
			$data['json_data'] = array('success' => false, 'error' => 'You are not logged in.');
			$this->load->view('json', $data);	
		}
	}
	
	public function _check_user($username, $password){
		$this->load->model('user');
		if($user = $this->user->get_by_username($username)){
			$this->load-library('pass_hash');
			if($this->pass_hash->check_password($user->password, $password)){
				return $user;
			}	
			else{
				return FALSE;	
			}
		}
		else{
			return FALSE;	
		}	
	}
    
}