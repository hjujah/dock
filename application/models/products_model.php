<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Products_model extends CI_Model
{
    public $id;
    public $id_cat;
	public $id_brand;
	public $name;
	public $img;
	public $cat_name;
	public $cat_name_cz;
	public $cat_name_rus;
	public $product_order;
		
			
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    
    }
    
    
    public function _create_array() {
        $array = array(
            'id' => $this->id,
            'id_cat' => $this->id_cat,
            'id_brand' => $this->id_brand,
            'name' => $this->name,
            'img' => $this->img,
            'cat_name' => $this->cat_name,
            'cat_name_cz' => $this->cat_name_cz,
            'cat_name_rus' => $this->cat_name_rus,
            'product_order' => $this->product_order
        );  
        return $array;   
    }
    
	public function check() {
        $query = "SELECT * FROM products WHERE id = '" . $this->id . "'";
        $result = $this->db->query($query);
        if($result->num_rows() == 0)
            return true;
        else
            return false;
    }
	
	
	public function get_all() {                                 
        $query = "SELECT * FROM products p INNER JOIN categories c ON p.id_cat = c.cat_id INNER JOIN brands b ON p.id_brand = b.brand_id ORDER BY p.product_order ASC";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }


    public function get_all_categories() {                                 
        $query = "SELECT * FROM categories ORDER BY 'order'";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
            	$row->objects = $this->get_3_by_id($row->cat_id);
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }
    
    public function get_all_brands() {                                 
        $query = "SELECT * FROM brands ORDER BY 'order'";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }
    
     public function get_all_pages() {                                 
        $query = "SELECT * FROM pages ORDER BY `order`";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }    
        else{
            return null;
        }
    }
    
    public function get_3_by_id($id) {                                 
        $query = 'SELECT * FROM products WHERE id_cat ='.$id.' ORDER BY RAND() LIMIT 0,1';
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
    
    
    public function get_all_references() {                                 
        $query = "SELECT * FROM `references` ORDER BY `order`";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row) {
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