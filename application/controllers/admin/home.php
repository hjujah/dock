<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends Admin_controller {
    
    public function index() {	
        $this->load->view('admin/index');
    }
    
}