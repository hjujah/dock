<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VA_Session extends CI_Session 
{

/**
* Update an existing session
*
* @access    public
* @return    void
*/
    function sess_update()
    {
       // skip the session update if this is an AJAX call!
       if ( !IS_AJAX )
       {
           parent::sess_update();
       }
    } 

}

/* End of file VA_Session.php */
/* Location: ./application/libraries/VA_Session.php */ 