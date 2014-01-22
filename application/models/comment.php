<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends CI_Model{
    
    public $id;
    public $uid;  
    public $email; 
    public $name;
	public $comment;
		
    public function __construct()
    { 
        parent::__construct();      
        $this->load->database();    
    }
    
    public function insert(){
        $array = $this->_create_array();
        $query = $this->db->insert_string('comments', $array);
        if($this->db->query($query) && $this->db->affected_rows() === 1)
        {
            $id = $this->db->insert_id();
            $this->id = $id;
            return true;
        }
        else{
            return false;
        } 
		
    }
  
	
	public function get_all()
    {                                 
        $query = "SELECT * FROM comments";
        $q = $this->db->query($query);

        if($q->num_rows()>0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }    
        else
        {
            return null;
        }
    } 
	
	public function get_all_approved()
    {                                 
        $query = "SELECT * FROM comments WHERE approved=1";
        $q = $this->db->query($query);

        if($q->num_rows()>0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }    
        else
        {
            return null;
        }
    } 
	
	public function get_all_unapproved()
    {                                 
        $query = "SELECT * FROM comments WHERE approved!=1";
        $q = $this->db->query($query);

        if($q->num_rows()>0)
        {
            foreach($q->result() as $row)
            {
                $data[] = $row;
            }
            return $data;
        }    
        else
        {
            return null;
        }
    } 
	
    public function delete($id)
    {         
        $query_gallery = "DELETE FROM comments WHERE id = '" . $id . "'";
        if($this->db->query($query_gallery) && $this->db->affected_rows() === 1)
            return true;
        else
            return false;
    }
	
	public function approve($id){  
        if(!isset($id) || empty($id) || !is_numeric($id)){
            $id = $this->id;
        }                                 
        $query = 'UPDATE comments SET approved = 1 WHERE id = '.$id;
        if($this->db->query($query) && $this->db->affected_rows() === 1){
            return true;
        }
        else{
            return false;
        }   
    }
    
    public function _create_array()
    {
        $array = array(
            'id' => $this->id,
            'uid' => $this->uid,
            'email' => $this->email,
            'name' => $this->name,
            'comment' => $this->comment,
        );  
        return $array;   
    }
}

?>