<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News extends Admin_controller {
    
    public function index() {
        $this->load->model('news_model');
        $data['news'] = $this->news_model->get_all();
        $this->load->view('admin/news_home', $data);       
    }

    public function create() {
        $this->load->view('admin/create_news');
    }

    public function gallery() {
    	$this->load->view('admin/create_gallery');
    }

    public function edit($id) {
        $this->load->model('news_model');
        $this->news_model->id = $id;
        $data['news'] = $this->news_model->get_by_id($id);

        $this->load->view('admin/create_news', $data);
    }

    public function edit_gallery($id) {
        $this->load->model('news_model');
        $this->news_model->id = $id;
        $data['images'] = $this->news_model->get_all_objects_by_id($id);

        $this->load->view('admin/create_news_gallery', $data);
    }

}