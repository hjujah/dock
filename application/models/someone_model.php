<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Someone_model extends CI_Model
{
    public $_id;
    public $_name;
	public $_category;
    public $_folder;
    public $_description;
    public $_description_cz;
    public $_link;
	public $_order;
    public $_section;
    public $_title;
    public $_src;
    public $_owner;

	
			
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    
    }
    
    private function _create_array_brands() {
        $arr = array(
            'brand' => $this->_name,
            'folder' => $this->_folder,
            'description' => $this->_description,
            'description_cz' => $this->_description_cz,
            'link' => $this->_link,
            'order' => $this->_order
        );  
        return $arr;   
    }

    private function _create_array_brands_update() {
        $arr = array(
            'brand' => $this->_name,
            'description' => $this->_description,
            'description_cz' => $this->_description_cz,
            'link' => $this->_link,
            'order' => $this->_order
        );  
        return $arr;   
    }

    private function _create_img_array() {
        $arr = array(
            'id_' . substr($this->_section, 0, -1) => $this->_owner,
            'folder' => $this->_folder,
            'title' => $this->_title,
            'src' => $this->_src,
            'order' => $this->_order
        );  
        return $arr;
    }

    private function _create_array() {
        $arr = array(
            'name' => $this->_name,
            'category' => $this->_category,
            'folder' => $this->_folder,
            'order' => $this->_order
        );  
        return $arr;
    }

    private function _create_array_update() {
        $arr = array(
            'name' => $this->_name,
            'category' => $this->_category,
            'order' => $this->_order
        );  
        return $arr;
    }

    public function insert() {
        $data = ($this->_section === 'brands' ? $this->_create_array_brands() : $this->_create_array());
        $table = $this->_section;
        $q = $this->db->insert_string($table, $data);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            $this->_id = $this->db->insert_id();
        } else {
            $this->_id = 0;
        }

        return $this->_id;
    }

    public function update() {
        $data = ($this->_section === 'brands' ? $this->_create_array_brands_update() : $this->_create_array_update());
        $table = $this->_section;
        $where = 'id = ' . $this->_id;
        $query = $this->db->update_string($table, $data, $where);

        if($this->db->query($query) && $this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert_img() {
        $data = $this->_create_img_array();
        $table = substr($this->_section, 0, -1) . '_images';
        $q = $this->db->insert_string($table, $data);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            $this->_id = $this->db->insert_id();
        } else {
            $this->_id = 0;
        }

        return $this->_id;
    }

    public function delete_image() {
        $table = substr($this->_section, 0, -1) . '_images';
        $q_get = "SELECT * FROM $table WHERE id = $this->_id";
        $query = $this->db->query($q_get);
        if($query->num_rows() > 0) {
            $image = $query->row();
        }

        $q_del = "DELETE FROM $table WHERE id = $this->_id";
        if($this->db->query($q_del) && $this->db->affected_rows() === 1) {
            unlink(realpath(APPPATH . '../img/' . $this->_section . '/' . $image->folder . '/' . $image->src));
            unlink(realpath(APPPATH . '../img/' . $this->_section . '/' . $image->folder . '/thumbs/' . $image->src));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_order() {
        $table = substr($this->_section, 0, -1) . '_images';
        $pos = array('order' => $this->_order, 'title' => $this->_title);
        $where = 'id = ' . $this->_id;
        $q = $this->db->update_string($table, $pos, $where);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_by_id() {                                 
        $table = $this->_section;
        $q = "SELECT * FROM $table WHERE id = $this->_id";
        $query = $this->db->query($q);

        if($query->num_rows() > 0) {
            $result = $query->row();
        } else {
            $result = FALSE;
        }

        return $result;
    }

    public function get_images_by_id() {
        $table = substr($this->_section, 0, -1) . '_images';
        $where = 'id_' . substr($this->_section, 0, -1) . ' = ' . $this->_id;
        $q = "SELECT * FROM $table WHERE $where ORDER BY `order` ASC";
        $query = $this->db->query($q);

        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $data[] = $row;
            }
        } else {
            $data = FALSE;
        }

        return $data;
    }

    public function delete() {
        $table = $this->_section;
        $table_images = substr($this->_section, 0, -1) . '_images';
        $where_images = 'id_' . substr($this->_section, 0, -1) . ' = ' . $this->_id;
        $img_dir = realpath(APPPATH . '../img/' . $this->_section . '/' . $this->_folder);

        $q = "DELETE FROM $table WHERE id = $this->_id";
        $q_img = "DELETE FROM $table_images WHERE $where_images";

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            if($this->db->query($q_img)) {
                system('/bin/rm -rf ' . escapeshellarg($img_dir));
                return TRUE;
            } else {
                return FLASE;
            }
        } else {
            return FALSE;
        }
    }

}