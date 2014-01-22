<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Model{
    public $id;
    public $username;
    public $password;
    public $email;
    public $display_name;
    public $privilegies;
    public $deleted;
    public $timestamp;
    
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    
    }
    
    public function insert(){
        $array = $this->_create_array();
        $query = $this->db->insert_string('users', $array);
        if($this->db->query($query) && $this->db->affected_rows() === 1){
            $id = $this->db->insert_id();
            $this->id = $id;
            return true;
        }
        else{
            return false;
        }  
    }   
    
    public function update(){
        $array = $this->_create_array();
        $where = 'id = '.$this->id;
        $query = $this->db->update_string('users', $array, $where);
        if($this->db->query($query) && $this->db->affected_rows() === 1){
            return true;
        }
        else{
            return false;
        }        
    }
     
    public function trash($id){  
        if(!isset($id) || empty($id) || !is_numeric($id)){
            $id = $this->id;
        }                                 
        $query = 'UPDATE users SET deleted = 1 WHERE id = '.$id;
        if($this->db->query($query) && $this->db->affected_rows() === 1){
            return true;
        }
        else{
            return false;
        }   
    }
    
    public function delete($id){
        if(!isset($id) || empty($id) || !is_numeric($id)){
            $id = $this->id;
        }                              
        $query1 = 'DELETE FROM users WHERE id='.$id;
        if($this->db->simple_query($query1) && $this->db->affected_rows() === 1){
            return true;    
        }        
        else{                           
            return false;
        }
    }    
    
    public function get_all($offset = FALSE, $limit = FALSE){
        if($offset === FALSE && $limit === FALSE){
            $query = "SELECT id, username, email, display_name, privilegies, deleted 
                        FROM users 
                        WHERE deleted = 0";  
            $q = $this->db->query($query);    
        }
        else if(is_numeric($offset) && is_numeric($limit) && $limit != 0){
            $query = "SELECT id, username, email, display_name, privilegies, deleted 
                        FROM users 
                        WHERE deleted = 0 
                        LIMIT ".$offset.", ".$limit;  
            $q = $this->db->query($query);    
        }
        else{
            return false;
        }
        if($q->num_rows()>0){
            foreach($q->result() as $row){
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return false;
        }
    }
    
    public function get_trash($offset = FALSE, $limit = FALSE){
        if($offset === FALSE && $limit === FALSE){
            $query = "SELECT id, username, email, display_name, privilegies, deleted 
                        FROM users 
                        WHERE deleted = 1";  
            $q = $this->db->query($query);    
        }
        else if(is_numeric($offset) && is_numeric($limit) && $limit != 0){
            $query = "SELECT id, username, email, display_name, privilegies, deleted 
                        FROM users 
                        WHERE deleted = 1 
                        LIMIT ".$offset.", ".$limit;  
            $q = $this->db->query($query);    
        }
        else{
            return false;
        }
        if($q->num_rows()>0){
            foreach($q->result() as $row){
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return false;
        }    
    }
    
    public function get_by_id($id){
        if(!isset($id) || empty($id) || !is_numeric($id)){
            $id = $this->id;
        }                             
        $query = "SELECT id, username, email, display_name, privilegies, deleted 
                    FROM users 
                    WHERE id = ".$id;
        $q = $this->db->query($query);
        if($q->num_rows() > 0){
            $row = $q->row();
            return $row;    
        }   
        else{
            return false;
        }
    }
    public function get_by_username($username){
        if(!isset($username) || empty($username) || strlen($username) < 3){
            return FALSE;
        }
		$username = $this->db->escape($username);                             
        $query = "SELECT id, username, display_name, privilegies, password 
                    FROM users 
                    WHERE username = ".$username;
        $q = $this->db->query($query);
        if($q->num_rows() > 0){
            $row = $q->row();
            return $row;    
        }   
        else{
            return FALSE;
        }
    }
    
    public function _create_array(){
        $array = array(                    
            'email' => $this->email,
            'display_name' => $this->display_name,
            'privilegies' => $this->privilegies,
            'deleted' => $this->deleted         
        );
        if(!empty($this->password)){
            $array['password'] = $this->password;
        }
        if(!empty($this->username)){
            $array['username'] = $this->username;
        }  
        return $array;   
    }
}
