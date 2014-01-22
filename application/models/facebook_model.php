<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook_model extends CI_Model {
 
    public function __construct()
    {
        parent::__construct();
 
        $config = array(
                        'appId'  => '255528254496024',
                        'secret' => 'ec3b65d5993ed4bb1de7fbdc6e21ec50',
                        'fileUpload' => true, // Indicates if the CURL based @ syntax for file uploads is enabled.
                        );
 
        $this->load->library('Facebook', $config);
 		
		
		
        $user = $this->facebook->getUser();
		
		//var_dump($user);
 
        // We may or may not have this data based on whether the user is logged in.
        //
        // If we have a $user id here, it means we know the user is logged into
        // Facebook, but we don't know if the access token is valid. An access
        // token is invalid if the user logged out of Facebook.
        $error = null;
        $profile = null;
        if($user)
        {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $profile = $this->facebook->api('/me?fields=id,name,link,email');
				
            } catch (FacebookApiException $e) {
                $error = $e;
                $user = null;
            }
        }
 
        $fb_data = array(
                        'me' => $profile,
                        'uid' => $user,
                        'error' => $error,
                        'loginUrl' => $this->facebook->getLoginUrl(),
                        'logoutUrl' => $this->facebook->getLogoutUrl(),
                    );
 
        $this->session->set_userdata('fb_data', $fb_data);
    }
}