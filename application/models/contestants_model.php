<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contestants_model extends CI_Model
{


    public $id;
    public $name;
	public $email;
	public $forename;
	public $surname;
	public $tel;
	public $gender;
	public $meal;
	public $payed;
	public $cost;
			
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    

    }
   
    
    public function _create_array() {
        $array = array(
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'forename' => $this->forename,
            'surname' => $this->surname,
            'tel' => $this->tel,
            'gender' => $this->gender,
            'meal' => $this->meal,
            'payed' => $this->payed,
            'cost' => $this->cost
        );  
        return $array;   
    }
    
    public function get_payed_number() {                                 
        $query = "SELECT * FROM contestants WHERE payed = 1";
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
    
    public function update_cost() {
        $table = 'contestants';
        $pos = array('cost' => $this->cost);
        $where = 'id = ' . $this->id;
        $q = $this->db->update_string($table, $pos, $where);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
    public function update_payed() {
        $table = 'contestants';
        $pos = array('payed' => 1);
        $where = 'id = ' . $this->id;
        $q = $this->db->update_string($table, $pos, $where);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    
    public function update() {
        $table = 'contestants';
        $data = $this->_create_array();
        $where = 'id = ' . $this->id;
        $q = $this->db->update_string($table, $data, $where);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert(){
        $data = $this->_create_array();
        $q = $this->db->insert_string('contestants', $data);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            $this->id = $this->db->insert_id();
        } else {
            $this->id = 0;
        }

        return $this->id;
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