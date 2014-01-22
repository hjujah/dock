<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fbuser extends CI_Model{
    public $id;
    public $uid;
    public $email;
    
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    
    }
    
    public function insert(){
        $array = $this->_create_array();
        $query = $this->db->insert_string('fbusers', $array);
        if($this->db->query($query) && $this->db->affected_rows() === 1){
            $id = $this->db->insert_id();
            $this->id = $id;
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
        $query1 = 'DELETE FROM fbusers WHERE id='.$id;
        if($this->db->simple_query($query1) && $this->db->affected_rows() === 1){
            return true;    
        }        
        else{                           
            return false;
        }
    }    
    
    public function get_all($offset = FALSE, $limit = FALSE){
        if($offset === FALSE && $limit === FALSE){
            $query = "SELECT id, uid, email 
                        FROM fbusers ";  
            $q = $this->db->query($query);    
        }
        else if(is_numeric($offset) && is_numeric($limit) && $limit != 0){
            $query = "SELECT id, uid, email
                        FROM fbusers 
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
    
    public function get_by_uid($uid){
        if(!isset($uid) || empty($uid) || !is_numeric($uid)){
            $uid = $this->uid;
        }                             
        $query = "SELECT id, uid, email 
                    FROM fbusers 
                    WHERE uid = ".$uid;
        $q = $this->db->query($query);
        if($q->num_rows() > 0){
            $row = $q->row();
            return $row;    
        }   
        else{
            return false;
        }
    }
    
    public function _create_array(){
        $array = array( 
        	'uid' => $this->uid,                  
            'email' => $this->email         
        );
		  
        return $array;   
    }
}
