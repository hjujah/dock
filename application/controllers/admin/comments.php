<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comments extends Admin_controller{
    
    public function index(){
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
    	$this->load->model('comment');
		
		$commentsA = $this->comment->get_all_approved();
		$commentsU = $this->comment->get_all_unapproved();
		if(count($commentsA)>0){$a = true;}else{$a=false;}
		if(count($commentsU)>0){$u = true;}else{$u=false;}
		$data['commentsA'] = array('success'=>$a, 'comments'=>$commentsA);
		$data['commentsU'] = array('success'=>$u, 'comments'=>$commentsU);
		
        $this->load->view('admin/comments', $data);
    }
    
//------------------------------------------------------------------------------------------------------------------

    public function editGallery($id = FALSE)
    {
    	$this->load->model('room_model');
		$rooms = $this->room_model->get_all();
		$data['rooms'] = $rooms;
		
        $id = $this->input->get('id');
        if($id && is_numeric($id)){
            $this->load->model('gallery_model');
            $gallery = $this->gallery_model->get_by_id($id);
            if($gallery->type == 'p')
            {
                $this->load->model('photo');
                $gallery->photos = $this->photo->get_all_by_gallery_id($id);
                $data['gallery'] = $gallery;
                $this->load->view('admin/editPhotoGallery', $data);
            }
            else if($gallery->type == 'v')
            {
                $this->load->model('video');
                $gallery->videos = $this->video->get_all_by_gallery_id($id);
                $data['gallery'] = $gallery;
                $this->load->view('admin/editVideoGallery', $data);
            }
			else{
				print_r($gallery);
			}
        }
        else{
            $data['error'] = current_url();
            $this->load->view('admin/error-page',$data);
            return;
        }
    }

//------------------------------------------------------------------------------------------------------------------

}
