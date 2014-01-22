<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends CI_Model
{
    public $id;
    public $headline;
	public $headline_cz;
	public $text;
	public $text_cz;
	public $images;
	public $date;
	public $size;
	public $order;
					
    public function __construct()
    { 
        parent::__construct();      
        $this->load->database();    
    }
    
	public function check()
    {
        $query = "SELECT * FROM news WHERE id = '" . $this->id . "'";
        $result = $this->db->query($query);
        if($result->num_rows() == 0)
            return true;
        else
            return false;
    }
	
    
    public function _create_array()
    {
        $array = array(
            'headline' => $this->headline,
            'headline_cz' => $this->headline_cz,
            'text' => $this->text,
            'text_cz' => $this->text_cz,
            'size' => $this->size,
            'date' => date('Y-m-d H:i:s', time())
        );  
        return $array;   
    }

    public function insert() {
        $data = $this->_create_array();
        $table = 'news';
        $q = $this->db->insert_string($table, $data);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            $this->id = $this->db->insert_id();
        } else {
            $this->id = 0;
        }

        return $this->id;
    }

    public function update() {
        $data = $this->_create_array();
        $table = 'news';
        $where = 'id = ' . $this->id;
        $query = $this->db->update_string($table, $data, $where);

        if($this->db->query($query)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete() {
        $table = 'news';
        $table_images = 'news_images';
        $where_images = 'id_news = ' . $this->id;
        $img_dir = realpath(APPPATH . '../img/news');

        $q = "DELETE FROM $table WHERE id = $this->id";
        $q_img = "SELECT * FROM $table_images WHERE $where_images";
        $del_img = "DELETE FROM $table_images WHERE $where_images";

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            $images = $this->db->query($q_img);
            if($images->num_rows() > 0) {
                foreach($images->result() as $i) {
                    if(file_exists($img_dir . '/' . $i->src) && !is_dir($img_dir . '/' . $i->src)) {
                        unlink($img_dir . '/' . $i->src);
                    }
                }

                if($this->db->query($del_img)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    public function insert_img() {
        $data = array(
            'id_news' => $this->news_id,
            'src' => $this->src
        );
        $table = 'news_images';
        $q = $this->db->insert_string($table, $data);

        if($this->db->query($q) && $this->db->affected_rows() === 1) {
            $this->id = $this->db->insert_id();
        } else {
            $this->id = 0;
        }

        return $this->id;
    }

    public function delete_image() {
        $table = 'news_images';
        $q_get = "SELECT * FROM $table WHERE id = $this->id";
        $query = $this->db->query($q_get);
        if($query->num_rows() > 0) {
            $image = $query->row();
        }

        $q_del = "DELETE FROM $table WHERE id = $this->id";
        if($this->db->query($q_del) && $this->db->affected_rows() === 1) {
            if(file_exists(realpath(APPPATH . '../img/news/' . $image->src))) {
                unlink(realpath(APPPATH . '../img/news/' . $image->src));
            }

            if(file_exists(realpath(APPPATH . '../img/news/thumbs/' . $image->src))) {
                unlink(realpath(APPPATH . '../img/news/thumbs/' . $image->src));
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }
	
	public function get_all_objects_by_id($id)
    {                                 
        $query = "SELECT * FROM news_images WHERE id_news = ".$id;
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
        $query = "SELECT *, date(date) as date FROM news n ORDER BY date DESC";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row)
            {
            	$row->images = $this->get_all_objects_by_id($row->id);
                $data[] = $row;
            }
			return $data;
		} else {
            return null;
        }
    }
	
	public function get_all_cz()
    {                                 
        $query = "SELECT id,headline_cz AS `headline`,text_cz AS `text`,date(date) as date,size FROM news ORDER BY date ASC";
        $q = $this->db->query($query);

        if($q->num_rows()>0) {
            foreach($q->result() as $row)
            {
            	$row->images = $this->get_all_objects_by_id($row->id);
                $data[] = $row;
            }
			return $data;
		} else {
            return null;
        }
    }
    
	
	public function get_by_id($id)
    {                                 
        $query = "SELECT * FROM news WHERE id=".$id;
        $q = $this->db->query($query);

        if($q->num_rows()>0)
        {
            foreach($q->result() as $row)
            {
            	$row->images = $this->get_all_objects_by_id($row->id);
                $data[] = $row;
            }
			
            return $data;
        }    
        else
        {
            return null;
        }
    }
	
}
?>