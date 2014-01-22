<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Brands_model extends CI_Model
{
    public $id;
    public $brand;
	public $description;
	public $objects;
	public $link;
	public $order;

			
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    

    }
    
	public function check() {
        $query = "SELECT * FROM brands WHERE id = '" . $this->id . "'";
        $result = $this->db->query($query);
        if($result->num_rows() == 0)
            return true;
        else
            return false;
    }
	
    
    public function _create_array() {
        $array = array(
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category,
            'thumbnail' => $this->thumbnail,
            'order' => $this->order
        );  
        return $array;   
    }
    
    public function get_all_partners($id) {                                 
        $query = "SELECT * FROM wholesale_partners WHERE id_brand = ".$id;
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

	
	public function get_all_images_by_id($id) {                                 
        $query = "SELECT * FROM brand_images WHERE id_brand = ".$id;
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
    
    public function get_3_by_id($id) {                                 
        $query = "SELECT * FROM brand_images WHERE id_brand = ".$id." ORDER BY `order` ASC LIMIT 3";
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
        $query = "SELECT * FROM brands ORDER BY 'order' ASC";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
            	$row->objects = $this->get_all_images_by_id($row->id);
            	$row->partners = $this->get_all_partners($row->id);
            	$row->thumbs = $this->get_3_by_id($row->id);
				//$row->category = explode(",",$row->category);
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }
	
	public function get_all_cz() {                                 
        $query = "SELECT id,brand,description_cz AS `description`,`order` FROM brands b ORDER BY b.order ASC";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
            	$row->objects = $this->get_all_images_by_id($row->id);
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }
	
	public function get_by_id($id) {                                 
        $query = "SELECT * FROM brands WHERE id=".$id;
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row){
            	$row->images = $this->get_all_images_by_id($row->id);
                $data[] = $row;
            }
            return $data;
        }    
        else {
            return null;
        }
    }
	
	public function updatePosition($id = NULL, $position = NULL){
		if($id != NULL) {
			$pos = array('home' => $position);
			$where = 'id ='.$id;
			$query = $this->db->update_string('works',$pos, $where);
			if($this->db->query($query) && $this->db->affected_rows() === 1 ){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}
	
	public function updateOrder($id = NULL, $position = NULL){
		if($id != NULL) {
			$pos = array('order' => $position);
			$where = 'id ='.$id;
			$query = $this->db->update_string('works',$pos, $where);
			if($this->db->query($query) && $this->db->affected_rows() === 1 ){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}
	
	public function updateCatOrder($id = NULL, $position = NULL){
		if($id != NULL) {
			$pos = array('category_order' => $position);
			$where = 'id ='.$id;
			$query = $this->db->update_string('works',$pos, $where);
			if($this->db->query($query) && $this->db->affected_rows() === 1 ){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}
	
	public function removeHome($id = NULL){
		if($id != NULL) {
			echo $id;
			$pos = array('home' => '0');
			$where = 'id ='.$id;
			$query = $this->db->update_string('works',$pos, $where);
			if($this->db->query($query) && $this->db->affected_rows() === 1 ){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}
	
	public function addHome($id = NULL){
		if($id != NULL) {
			$pos= array('home' => '200');
			$where = 'id ='.$id;
			$query = $this->db->update_string('works',$pos, $where);
			if($this->db->query($query) && $this->db->affected_rows() === 1 ){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}

}
?>