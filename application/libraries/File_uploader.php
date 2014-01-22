<?php   if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class File_uploader {
    private $allowedExtensions = array();
    private $sizeLimit = 1048576;
    private $file;
    private $CI;

    function __construct($params = array()){
        $this->CI =& get_instance();        
        $allowedExtensions = array_map("strtolower", (isset($params['allowedExtensions']))?$params['allowedExtensions']:array());
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = (isset($sizeLimit))?$sizeLimit:1048576;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {  
            $this->CI->load->library('uploadqq/uploaded_file_xhr');
            $this->file = &$this->CI->uploaded_file_xhr; 
        } elseif (isset($_FILES['qqfile'])) {
            $this->CI->load->library('uploadqq/uploaded_file_form');
            $this->file = &$this->CI->uploaded_file_form;
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'success' : false, 'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_dir($uploadDirectory)){
            return array('success' =>false, 'error' => "Server error. Directory does not exist. ".$uploadDirectory);
        }	
			
        if (!is_writable($uploadDirectory)){
            return array('success' =>false, 'error' => "Server error. Upload directory isn't writable.");
        }
        
        if (!$this->file){
            return array('success' =>false, 'error' => 'No files were uploaded.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('success' =>false, 'error' => 'File is empty');
        }
        
        if ($size > $this->sizeLimit) {
            return array('success' =>false, 'error' => 'File is too large');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];

        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('success' =>false, 'error' => 'File has an invalid extension, it should be one of '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
        }
        
        $url = $uploadDirectory . $filename . '.' . $ext;
        if ($this->file->save($url)){
            $dim = getimagesize($url);
    
            $width = $dim[0]; 
            $height = $dim[1];
            return array('success' =>true, 'tempurl'=> $url, 'filename'=> $filename . '.' . $ext, 'ext'=> $ext, 'size'=> $size, 'height'=>$height, 'width'=>$width );
        } else {
            return array('success' =>false, 'error'=> 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
        
    }    
}
