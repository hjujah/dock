<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Photo extends CI_Model{
    
    public $id;
    public $gallery_id;  
    public $url; 
    public $thumb_url;
		
    public function __construct()
    { 
        parent::__construct();      
        $this->load->database();    
    }
    
    public function insert(){
        $array = $this->_create_array();
        $query = $this->db->insert_string('photos', $array);
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
    
    public function get_by_id($id)
    {
        if(!isset($id) || empty($id) || !is_numeric($id))
        {
            $id = $this->id;
        }                            
        $query = "SELECT * FROM photos WHERE id = ".$id;
        $q = $this->db->query($query);
        if($q->num_rows() > 0)
        {
        	
            $row = $q->row();
            $row->thumb_permalink = base_url('img/galleryphotos/'.$row->thumb_url);
            $row->permalink = base_url('img/galleryphotos/'.$row->url);
            return $row;    
        }   
        else{
            return false;
        }
    }
	
    public function get_all_by_gallery_id($id)
    {                                 
        $query = "SELECT * FROM photos WHERE gallery_id = ".$id;
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
	
	public function get_first_by_gallery_id($id)
    {                                 
        $query = "SELECT * FROM photos WHERE gallery_id = ".$id." LIMIT 1";
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
	
	public function get_all()
    {                                 
        $query = "SELECT * FROM photos";
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
        $query = 'DELETE FROM photos WHERE id='.$id;
        
        if($this->db->simple_query($query) && $this->db->affected_rows() === 1)
        {
            return true;    
        }        
        else
        {                           
            return false;
        }
    }
    
    public function _create_array()
    {
        $array = array(
            'gallery_id' => $this->gallery_id,
            'url' => $this->url,
            'thumb_url' => $this->thumb_url,
        );  
        return $array;   
    }
}

?>