<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller{


	function __construct(){
		
		parent::__construct();
		define("DS", DIRECTORY_SEPARATOR);	
	}
    
//-----------------------------------------------------------------------------------------------------------

    public function index()
    {
        echo "ASDS";
    }   

    function _file_get_contents_curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }  
	

	public function get_content()
	{
        $url = urldecode($this->input->get('url'));
		switch ($url) {
		    case 'home':
        		$this->load->model('home_model');
				$data = json_encode($this->home_model->get_all());
				echo $data;
		        break;
		    case 'projects':
		       	$this->load->model('project_model');
				$data = json_encode($this->project_model->get_all());	
				echo $data;
		        break;
		    default :
		        echo $url;
		        break;
		}		
    }
    
    public function updatePayed(){
    	$this->load->model('contestants_model');
	    $id = $this->input->post('id');	  
	    $amount = $this->input->post('amount');	
	    $mail = $this->input->post('email');
	    $name = $this->input->post('name');		
	    
	    $this->contestants_model->id = $id;  
	    $this->contestants_model->cost = $amount;      
        $id = $this->contestants_model->update_payed();
        $p = $this->contestants_model->update_cost();
        
        $am = ($amount * 1)/10;
        
        $message = "Please keep this receipt as confirmation of your payment and entry.A summary of your purchase is included below.
We will be in touch shortly via e-mail with more information including details of training rides and the latest news in the build up to the start. If you have any questions in the meanwhile, please feel free to contact us at any time at team@curadmir.com. TOTAL (vat incl.): GBP ". $am .".00"; 

        mail ( $mail , 'Congratulations, your place has been secured on Curadmír  2014!' , $message );
        
        $form['updated'] = $p;
        $form['cost'] = $amount;
        $form['id'] = $id;
        $data['json_data'] = $form;
        $this->load->view('json', $data);
    }
    
    
    public function joinUs(){
    	$this->load->model('contestants_model');
	    $form = $this->input->post('form');	    	    
	    $this->contestants_model->name = $form['name'];
	    $this->contestants_model->surname = $form['surname'];
        $this->contestants_model->email = $form['email'];       
        $id = $this->contestants_model->insert();
        $form['id'] = $id;
     
        $data['json_data'] = $form;
        $this->load->view('json', $data);

    }
    
    public function personalInfo(){
    	$this->load->model('contestants_model');
	    $form = $this->input->post('form');
	    
	    $this->contestants_model->id = $form['id'];
	    $this->contestants_model->name = $form['name'];
	    $this->contestants_model->email = $form['email'];
	    $this->contestants_model->birthDate = $form['birthDate'];
        $this->contestants_model->forename = $form['forename'];  
        $this->contestants_model->gender = $form['gender'];
        $this->contestants_model->meal = $form['meal'];
        $this->contestants_model->othermeal = $form['othermeal'];
        $this->contestants_model->surname = $form['surname'];
        $this->contestants_model->tel = $form['tel'];
         
	    $id = $this->contestants_model->update();
	    echo $id;
    }
    
    public function addHome(){
	    $this->load->model('home_model');
    	$this->load->model('news_model');
    	$this->load->model('work_model');
    	$id = $this->input->post('id');
	    $page = $this->input->post('page');
	    
	    if($page=='works'){
		    $this->work_model->addHome($id);
	    }	
	    elseif($page=='news'){
		    $this->news_model->addHome($id);
	    }
    }
    
    public function removeHome(){
	    $this->load->model('home_model');
    	$this->load->model('news_model');
    	$this->load->model('work_model');
    	$id = $this->input->post('id');
	    $page = $this->input->post('page');

	    if($page=='works'){
		    $this->work_model->removeHome($id);
	    }
	    elseif($page=='news'){
		    $this->news_model->removeHome($id);
	    }
    }
    
    public function reposition(){
    
    	$this->load->model('home_model');
    	$this->load->model('news_model');
    	$this->load->model('work_model');
	    $elems = $this->input->post('elems');
	    $page = $this->input->post('page');
	    	    
	    foreach($elems as $elem){    	    	
			if($page=='home'){
		    	if($elem['category']=='home'){	    		
			    	$this->home_model->updatePosition($elem['id'], $elem['home']);
		    	}elseif($elem['category']=="news"){
			    	$this->news_model->updatePosition($elem['id'], $elem['home']);
		    	}else{
			    	$this->work_model->updatePosition($elem['id'], $elem['home']);
		    	}
	    	}else{    	
	    		if($elem['category']=='works'){			
	    			echo $page;
	    			echo $elem['category'];
	    			
	    			if($page == $elem['category']){
		    			$this->work_model->updateOrder($elem['id'], $elem['home']);
		    		}else{
			    		$this->work_model->updateCatOrder($elem['id'], $elem['home']);
		    		}
	    		}elseif($elem['category']=='news'){
		    		$this->news_model->updateOrder($elem['id'], $elem['home']);
	    		}
	    	}
	    }
    }
    
	
}
?>
