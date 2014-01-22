<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_ajax extends Admin_controller{
	

    public function addUser(){
        $this->load->model('user');
        $errors = array();
        $username = urldecode($this->input->post('username'));
        $email = urldecode($this->input->post('email'));
        $display_name = urldecode($this->input->post('display_name'));
        $privilegies = urldecode($this->input->post('privilegies'));
        $password = urldecode($this->input->post('password'));
        $repeat_pass = urldecode($this->input->post('repeat_pass'));                                

        if(!empty($username) && strlen($username)>=3){
            $this->user->username = $username;
        }
        else{
            array_push($errors, array('field'=>'username', 'error'=>'This field is required'));    
        }
        if(!empty($email) && strlen($email)>=3){
            $this->user->email = $email;
        }
        else{
            array_push($errors, array('field'=>'email', 'error'=>'This field is required'));    
        }
        if(!empty($display_name) && strlen($display_name)>=3){
            $this->user->display_name = $display_name;
        }
        else{
            array_push($errors, array('field'=>'display_name', 'error'=>'This field is required'));    
        }
        if(is_numeric($privilegies) && ($privilegies == 0 || $privilegies == 1)){
            $this->user->privilegies = $privilegies;
        }
        else{
            array_push($errors, array('field'=>'privilegies', 'error'=>'This field is required'));    
        }
        if(!empty($password) && strlen($password) > 4 && $password == $repeat_pass){
            $this->load->library('pass_hash');
            $this->user->password = $this->pass_hash->hash($password);
        }
        else{
            array_push($errors, array('field'=>'password', 'error'=>'This field is required'));    
        }
        
        $this->user->deleted = 0;
        
        if(count($errors) == 0){                      
            if($this->user->insert()){
                $data['json_data'] = array('success'=>true, 'id' => $this->user->id);
                $this->load->view('json', $data);
            }   
            else{
                $data['json_data'] = array('success'=>false, 'error' => 'Oops, something is wrong!');
                $this->load->view('json', $data);    
            }
        }else{
            $data['json_data'] = array('success'=>false, 'error' => 'Oops, something is wrong!', 'errors'=>$errors);
            $this->load->view('json', $data);
        }  
        
    }  

    public function updateUser(){
        $this->load->model('user');
        $errors = array();
        $id = urldecode($this->input->post('id'));            
        $email = urldecode($this->input->post('email'));
        $display_name = urldecode($this->input->post('display_name'));
        $privilegies = urldecode($this->input->post('privilegies'));
        $password = urldecode($this->input->post('password'));
        $repeat_pass = urldecode($this->input->post('repeat_pass'));                                

        
        if(!empty($id) && is_numeric($id)){
            $this->user->id = $id;
        }
        else{
            array_push($errors, array('field'=>'name', 'error'=>'This field is required'));    
        }
        if(!empty($email) && strlen($email)>=3){
            $this->user->email = $email;
        }
        else{
            array_push($errors, array('field'=>'email', 'error'=>'This field is required'));    
        }
        if(!empty($display_name) && strlen($display_name)>=3){
            $this->user->display_name = $display_name;
        }
        else{
            array_push($errors, array('field'=>'display_name', 'error'=>'This field is required'));    
        }
        if(is_numeric($privilegies) && ($privilegies == 0 || $privilegies == 1)){
            $this->user->privilegies = $privilegies;
        }
        else{
            array_push($errors, array('field'=>'privilegies', 'error'=>'This field is required'));    
        }
        if(!empty($password) && strlen($password) > 4 && $password == $repeat_pass){
            $this->load->library('pass_hash');
            $this->user->password = $this->pass_hash->hash($password);
        }
        else{
            $this->user->password = 0;    
        }      

        $this->user->deleted = 0;
        
        if(count($errors) == 0){                      
            if($this->user->update($id)){
                $data['json_data'] = array('success'=>true, 'msg' => 'User successfuly updated.');
                $this->load->view('json', $data);
            }   
            else{
                $data['json_data'] = array('success'=>false, 'error' => 'Oops, something is wrong!');
                $this->load->view('json', $data);    
            }
        }else{
            $data['json_data'] = array('success'=>false, 'error' => 'Oops, something is wrong!', 'errors'=>$errors);
            $this->load->view('json', $data);
        }         
    }  

    public function deleteUser(){
        if($this->input->get('id') && is_numeric($this->input->get('id'))){
            $id = $this->input->get('id');
            $this->load->model('user');
            if($this->user->trash($id)){
                $data['json_data'] = array('success'=>true, 'msg'=> 'User successfuly deleted.');
                $this->load->view('json', $data);    
            }
            else{
                $data['json_data'] = array('success'=>false, 'error'=> 'Oops, something went wrong!');
                $this->load->view('json', $data);    
            }   
        }
        
    }
	
	
	/*
	 * to create default Admin user: 
	 * 1) change parent class of this ctrl to Public_Controller
	 * 2) uncomment 2 function below
	 * 3) go to - http://<base_url>/admin/users_ajax/createDefaultUser?secret=7tapurEDepre
	 * 
	 * Change everything back!!!
	 * 
	 */
	 
	/*
	public function createDefaultUser(){
		$secret = '7tapurEDepre';
		
		if ($this->input->get('secret') == $secret){
			$this->_addDefaultAdminUser();
		};
		
	}
	
	private function _addDefaultAdminUser(){
       
	    $this->load->model('user');
        $errors = array();
        $username = 'Admin';
        $email = 'admin@gmail.com';
        $display_name = 'Admin';
        $privilegies = 1;
        $password = 'admin';
        $repeat_pass = urldecode($this->input->post('repeat_pass'));                                

        $this->user->username = $username;
		$this->user->email = $email;
        $this->user->display_name = $display_name;
        $this->user->privilegies = $privilegies;

        $this->load->library('pass_hash');
        $this->user->password = $this->pass_hash->hash($password);
        
        $this->user->deleted = 0;
                     
        if($this->user->insert()){
        	
			$result = array(
			
				'user_id' => $this->user->id,
				'username' => $this->user->username,
				'password' => $password // not hashed vallue
			);
			
			var_dump($result);
        }   
        else{
            echo 'unable to create new user!';   
        }

	}  
	*/
	
}
