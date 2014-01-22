<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homepage extends Admin_controller{
    
    public function index(){
        $this->load->model('home_model');
        $data['slides'] = $this->home_model->get_all();
        $this->load->view('admin/homepage_home', $data);       
    }

    public function create_slide() {
        $this->load->view('admin/create_slide');
    }

    public function edit_slide($id) {
        $this->load->model('home_model');
        $this->home_model->id = $id;
        $data['slide'] = $this->home_model->get_by_id();

        $this->load->view('admin/create_slide', $data);
    }

}