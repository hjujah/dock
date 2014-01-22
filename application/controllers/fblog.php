<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fblog extends Public_Controller {

    public function index()
    {
		if($this->input->is_ajax_request()){
			$uid = $this->input->post('uid');
			$email = $this->input->post('email');
			
			if(empty($uid) ){
				$data['json_data'] = array('success' => false, 'error' => 'Invalid parameters.');
				$this->load->view('json', $data);
				return;
			}
			
			$this->load->model('fbuser');
			$user = $this->fbuser->get_by_uid($uid);
			if(!$user){
				$this->fbuser->uid = $uid;
				$this->fbuser->email = $email;
				if($this->fbuser->insert()){
					$data['json_data'] = array('success' => true, 'postToWall' => true);
					$this->load->view('json', $data);
				}else{
					$data['json_data'] = array('success' => false, 'error' => 'Error occured while trying to insert user in database');
					$this->load->view('json', $data);
				}
			}else{
				if($user->email != $email){
					if($this->fbuser->delete($user->id)){
						$this->fbuser->email = $email;
						$this->fbuser->uid = $uid;
						if($this->fbuser->insert()){
							$data['json_data'] = array('success' => true);
							$this->load->view('json', $data);
						}
						else{
							$data['json_data'] = array('success' => false, 'error' => 'Error occured while trying to insert user in database');
							$this->load->view('json', $data);
						}
					}else{
						$data['json_data'] = array('success' => false, 'error' => 'Error occured while trying to delete user from database');
						$this->load->view('json', $data);
					}
				}else{
					$data['json_data'] = array('success' => true);
					$this->load->view('json', $data);
				}
				
			}
		}
    }
	
	function  _log_fb_user()
	{
		
	}

}

