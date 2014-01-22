<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Photo_model extends CI_Model
{
    public $id;
    public $id_stage;
	public $order;
	public $src;
			
    public function __construct(){ 
        parent::__construct();      
        $this->load->database();    

    }
    
    
    public function _create_array() {
        $array = array(
            'id' => $this->id,
            'name' => $this->src,
            'category' => $this->id_stage,
            'order' => $this->order
        );  
        return $array;   
    }

	
	public function get_all() {                                 
        $query = "SELECT * FROM photos ORDER BY `order` ASC";
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