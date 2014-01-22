<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home_model extends CI_Model{
	
    public $id;
    public $src;
	public $order;
	public $text_en;
	public $text_cz;
	public $text_rus;
		
	public function __construct(){ 
        parent::__construct();      
        $this->load->database();    
    }

    private function _create_array() {
    	$arr = array(
    		'src' => $this->src,
    		'order' => $this->order,
    		'text_en' => $this->text_en,
    		'text_cz' => $this->text_cz,
    		'text_rus' => $this->text_rus
		);

    	return $arr;
    }
	
	public function get_all()
	{
            $query = "SELECT * FROM home ORDER BY 'order'";
            $q = $this->db->query($query);

            if($q->num_rows()>0)
            {
                foreach($q->result() as $row){
                    $data[] = $row;
                }
                return $data;
            }    
            else{
                return false;
            }
	}

	public function get_by_id() {
		$query = "SELECT * FROM home WHERE id=$this->id";
		$q = $this->db->query($query);

		if($q->num_rows()>0)
		{
		    return $q->row();
		}    
		else{
		    return false;
		}
	}

	public function insert() {
		$data = $this->_create_array();

		$q = $this->db->insert_string('home', $data);

		if($this->db->query($q) && $this->db->affected_rows() === 1) {
		    $this->id = $this->db->insert_id();
		} else {
		    $this->id = 0;
		}

		return $this->id;
	}

	public function update() {
		$data = array(
			'text' => $this->text,
			'order' => $this->order
		);
		$where = 'id =' . $this->id;
		$query = $this->db->update_string('home', $data, $where);

		if($this->db->query($query) && $this->db->affected_rows() === 1 ) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function update_with_img() {
		$data = $this->_create_array();
		$where = 'id=' . $this->id;
		$q = $this->db->update_string('home', $data, $where);

		if($this->db->query($q) && $this->db->affected_rows() === 1) {
		    return TRUE;
		} else {
		    return FALSE;
		}
	}

	public function delete() {
		$slide = $this->get_by_id();
		$url = realpath(APPPATH . '../img/home/' . $slide->src);

		if(file_exists($url) && $slide->src !== NULL) {
		    unlink($url);
		}

		$q = "DELETE FROM `home` WHERE id=$this->id";
		if($this->db->query($q) && $this->db->affected_rows() === 1 ){
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function delete_img() {
		$slide = $this->get_by_id();
		$url = realpath(APPPATH . '../img/home/' . $slide->src);
		$data= array('src' => NULL);
		$where = 'id =' . $this->id;
		$query = $this->db->update_string('home', $data, $where);

		if($this->db->query($query) && $this->db->affected_rows() === 1 ) {
			if(file_exists($url)) {
				unlink($url);
			}
			return TRUE;
		}else {
			return FALSE;
		}
	}
	
	public function updatePosition($id = NULL, $position = NULL){
		if($id != NULL) {
			$pos= array('home' => $position);
			$where = 'id ='.$id;
			$query = $this->db->update_string('home',$pos, $where);
			if($this->db->query($query) && $this->db->affected_rows() === 1 ){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}
	
	public function updateOrder($id = NULL, $position = NULL){
		if($id != NULL) {
			$pos= array('order' => $position);
			$where = 'id ='.$id;
			$query = $this->db->update_string('home',$pos, $where);
			if($this->db->query($query) && $this->db->affected_rows() === 1 ){
				return TRUE;
			}else {
				return FALSE;
			}
		}
	}
	
	
}
?>