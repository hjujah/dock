<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
* 
* 
*/
if ( ! function_exists('show_custom_error'))
{
    function render_gallery_title($gallery){                                                                       

        $markup  =     
           '<span class="brand">'.$gallery->brand_name.'</span>
            <span class="at">@</span> 
            <span class="venue">'.$gallery->venue.'</span>, 
            <span class="city">'.$gallery->city.'</span>';
            
        echo $markup;
                                             
    }
}

// --------------------------------------------------------------------


/**
 * str_isotope_filter
 *
 * Lowercase alphanumeric characters, dashes and underscores are allowed.
 * 
 * @access  public
 * @param   string  $str The string to be cleaned
 * @return  string 	The processed string
 */
if ( ! function_exists('str_isotope_filter'))
{
    function str_isotope_filter($str){                                                                       

        $CI =& get_instance();
        $CI->load->helper('formatting');
        
        $str = remove_accents($str); 
        $str = sanitize_html_class($str);
        $str = strtolower($str);
        
        return $str;
    }
}

// --------------------------------------------------------------------