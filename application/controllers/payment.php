<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

    /**
        * Index Page for this controller.
        *
        * Maps to the following URL
        * 		http://example.com/index.php/welcome
        *	- or -  
        * 		http://example.com/index.php/welcome/index
        *	- or -
        * Since this controller is set as the default controller in 
        * config/routes.php, it's displayed at http://example.com/
        *
        * So any other public methods not prefixed with an underscore will
        * map to /index.php/welcome/<method_name>
        * @see http://codeigniter.com/user_guide/general/urls.html
        */
        

	public function _remap()
    {
    	$this->load->library('stripe');
	    
		// Get the credit card details submitted by the form		
		/* $token = "tok_102sxv2RMcqmDVT4JsVOYQtD"; */ 
		
		$token = $this->input->post('token');
		$plan = $this->input->post('plan');
		$email = $this->input->post('email');
		
		$this->load->model('contestants_model');   	         
        $no = $this->contestants_model->get_payed_number();
        $no1 = count($no);
        $price = ($no1 <= 100) ? 37500 : 47500; 

        //print_r($this->stripe->customer_list());
        
		// Create the charge on Stripe's servers - this will charge the user's card
		try {
			
			if($plan == "monthly"){
				$response = $this->stripe->customer_create( $token, $email, "This is the curadmir payment", $plan );
			}else{
				$response =  $this->stripe->charge_card($price,$token,"This is the curadmir payment");
			}
			
			$data['json_data'] = json_decode($response);
			$this->load->view('json', $data);
			
		} catch(Stripe_CardError $e) {
			echo "The card has been declined";
		  // The card has been declined
		}
	    
	}	 
       
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */