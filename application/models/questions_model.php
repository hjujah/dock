<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Questions_model extends CI_Model
{
    public $id;
    public $name;
	public $order;
	public $questions;
			
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    

    }
    
    
    public function _create_array() {
        $array = array(
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->questions,
            'order' => $this->order
        );  
        return $array;   
    }


    public function get_all_questions_by_id_reversed($id) {                                 
        $query = "SELECT * FROM questions WHERE id_group = ".$id." ORDER BY `order` DESC";
        $q = $this->db->query($query);

        if($q->num_rows()>0){
            foreach($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }    
        else {
            return null;
        }
    }
    
    public function get_all_reversed() {                                 
        $query = "SELECT * FROM groups ORDER BY `order` DESC";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
            	$row->questions = $this->get_all_questions_by_id_reversed($row->id);
				//$row->category = explode(",",$row->category);
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }
    
	
	public function get_all_questions_by_id($id) {                                 
        $query = "SELECT * FROM questions WHERE id_group = ".$id;
        $q = $this->db->query($query);

        if($q->num_rows()>0){
            foreach($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }    
        else {
            return null;
        }
    }
    
	
	public function get_all() {                                 
        $query = "SELECT * FROM groups ORDER BY `order` ASC";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
            	$row->questions = $this->get_all_questions_by_id($row->id);
				//$row->category = explode(",",$row->category);
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }

}
?>