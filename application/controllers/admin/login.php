<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
    
    public function index(){
    	$data['post'] = FALSE;
		$data['error'] = '';
		$data['username'] = '';
        $username = $this->input->post('username');
		$password = $this->input->post('password');
		if($username === FALSE || $password === FALSE){
        	$this->load->view('admin/login', $data);
			return;
        }
		
		if(empty($username) || empty($password)){
			$data['post'] = TRUE;
			$data['error'] = 'Invalid parameters.';
			$data['username'] = $username;
			$this->load->view('admin/login', $data);
			return;
		}
		
		
		if($user = $this->_check_user($username, $password)){
			$this->load->library('session');
			$this->session->set_userdata(array('user_id' => $user->id, 'username' => $user->username, 'display_name' => $user->display_name, 'privilegies' => $user->privilegies, 'logged_in' => TRUE));
			redirect(base_url('admin/home/'));	
		}
		else{
			$data['post'] = TRUE;
			$data['error'] = 'Username or/and password are incorrect.';
			$data['username'] = $username;
			$this->load->view('admin/login', $data);
			return;
		}
    }
	
	public function login_ajax(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		if(empty($username) || empty($password)){
			$data['json_data'] = array('success' => false, 'error' => 'Invalid parameters.');
			$this->load->view('json', $data);
			return;
		}
		if($user = $this->_check_user($username, $password)){
			$this->load->library('session');
			$this->session->set_userdata(array('user_id' => $user->id, 'username' => $user->username, 'display_name' => $user->display_name, 'logged_in' => TRUE));
			$data['json_data'] = array('success' => true, 'error' => 'You are logged in successfuly.');
			$this->load->view('json', $data);
		}
		else{
			$data['json_data'] = array('success' => false, 'error' => 'Username and/or password are incorrect.');
			$this->load->view('json', $data);	
		}
    }
	
	public function logout(){
		$this->load->library('session');
		if($this->session->userdata('logged_in')){
			$this->session->sess_destroy();
			redirect(base_url('admin/login/'), 'location');	
		}
		else{
			$data['heading'] = 'Logout error';
			$data['body'] = 'You are not logged in.';
			$data['link'] = base_url('admin/login');
			$data['link_title'] = 'Login';
			$this->load->view('admin/error-page', $data);	
		}
	}
	
	public function _check_user($username, $password){
		
		/*
		if ($username == 'admin' && $password == 'admin123'){
			$this->load->model('user');
			$user = $this->user->get_by_username($username);
			return $user;
		} else {
			return false;
		}
		*/	
		$this->load->model('user');
		if($user = $this->user->get_by_username($username)){
			
			$this->load->library('pass_hash');
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