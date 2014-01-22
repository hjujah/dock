<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends Admin_controller
{
    function __construct()
    {       
        parent::__construct();
        define("DS", DIRECTORY_SEPARATOR);
    }

    public function image_upload_ajax()
    {
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array();
        // max file size in bytes
        $sizeLimit = 5 * 1024 * 1024;
        $params = array(
            'allowedExtensions'=>$allowedExtensions,
            'sizeLimit'=>$sizeLimit
        );
        $this->load->library('file_uploader', $params);
        $result = $this->file_uploader->handleUpload(realpath(APPPATH.'../tmp/').DS);
        
        $data['json_data'] = $result;
        $this->load->view('json', $data);
    }

    public function createSomeone_ajax() {
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $folder = $this->input->post('folder');
        $order = $this->input->post('order');
        $section = $this->input->post('section');
        $description = $this->input->post('description');
        $description_cz = $this->input->post('description_cz');
        $link = $this->input->post('link');

        $this->load->model('someone_model');
        $this->someone_model->_name = $name;
        $this->someone_model->_category = $category;
        $this->someone_model->_folder = $folder;
        $this->someone_model->_order = $order;
        $this->someone_model->_section = $section;
        $this->someone_model->_description = $description;
        $this->someone_model->_description_cz = $description_cz;

        if($section === 'brands') {
            $this->someone_model->_link = $link;
        }

        $id = $this->someone_model->insert();
        
        if($id !== 0) {
            $path = BASEPATH . '../img/' . $section . DS . $folder . '/thumbs';

            if (!file_exists($path)) {

                if (!mkdir($path , 0755, TRUE)) {
                    $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to create folder.');
                } else {
                    $data['json_data'] = array('success' => TRUE, 'id' => $id, 'folder' => $folder);
                }

            } else {
                $data['json_data'] = array('success' => FALSE, 'msg' => 'Folder for this ' . substr($section, 0, -1) . ' already exists on the file system.');
            }

        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to insert this ' . substr($section, 0, -1) . ' into database.');
        }

        $this->load->view('json', $data);
    }

    public function updateSomeone_ajax() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $category = $this->input->post('category');
        $order = $this->input->post('order');
        $section = $this->input->post('section');
        $description = $this->input->post('description');
        $description_cz = $this->input->post('description_cz');
        $link = $this->input->post('link');

        $this->load->model('someone_model');
        $this->someone_model->_id = $id;
        $this->someone_model->_name = $name;
        $this->someone_model->_category = $category;
        $this->someone_model->_order = $order;
        $this->someone_model->_section = $section;
        $this->someone_model->_description = $description;
        $this->someone_model->_description_cz = $description_cz;

        if($section === 'brands') {
            $this->someone_model->_link = $link;
        }
        
        if($this->someone_model->update()) {
            $data['json_data'] = array('success' => TRUE, 'msg' => 'Successfuly updated ' . substr($section, 0, -1) . ' ' . $name);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to update ' . substr($section, 0, -1) . ' ' . $name . '. Please try again.');
        }

        $this->load->view('json', $data);
    }

    public function addPhotoDb_ajax() {
        $src = $this->input->post('src');
        $section = $this->input->post('section');
        $title = $this->input->post('title');
        $link = $this->input->post('link');
        $folder = $this->input->post('folder');
        $order = $this->input->post('order');
        $owner = $this->input->post('owner');
        $tempurl = $this->input->post('tempurl');

        $this->load->model('someone_model');
        $this->someone_model->_owner = $owner;
        $this->someone_model->_section = $section;
        $this->someone_model->_folder = $folder;
        $this->someone_model->_title = $title;
        $this->someone_model->_link = $link;
        $this->someone_model->_order = $order;

        if($tempurl) {
            $strarr = explode('.', $tempurl);
            $ext = $strarr[count($strarr) - 1];
            $name = time() . "_" . md5(uniqid());
            
            $params['fileName'] = $tempurl;
            $this->load->library('image_resize', $params);
            
            $dir = realpath(APPPATH . '../img/' . $section . DS . $folder) . DS;

            while (file_exists($dir . $name . '.' . $ext)) {
                $name .= rand(10, 99);
            }

            $new_src = $name . '.' . $ext;
            
            list($src_w, $src_h) = getimagesize($tempurl);

            $ratio = $src_w / $src_h;
            $new_w = round(1080 * $ratio);

            if($src_h !== 1080) {
                $resized_image = new Image_resize($params);
                $resized_image->resizeImage($new_w, 1080, 'auto');
                $resized_image->saveImage($dir . $new_src, 90);    
            } else {
                if(!rename($tempurl, $dir . $new_src)) {
                    $data['json_data'] = array('success'=>FALSE, 'msg' => 'An error occured while saving the image.');
                    $this->load->view('json', $data);
                    return;
                }
            }

            $thumb_params['fileName'] = $dir . $new_src;
            $thumb = new Image_resize($thumb_params);
            $thumb->resizeImage(635, 766, 'crop');
            $thumb->saveImage($dir . 'thumbs/' . $new_src, 90);

            if (file_exists($tempurl)) {
                unlink($tempurl);
            }

            $this->someone_model->_src = $new_src;
            $id = $this->someone_model->insert_img();

            if($id !== 0) {
                $data['json_data'] = array('success' => TRUE, 'id' => $id, 'src' => $new_src, 'section' => $section, 'title' => $title, 'link' => $link);
                $this->load->view('json', $data);
            } else {
                unlink($dir . $new_src);
                unlink($dir . '/thumbs/' . $new_src);

                $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to insert image into database.');
                $this->load->view('json', $data);
            }
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Image not available.');
            $this->load->view('json', $data);
        }
    }

    public function deleteImage_ajax() {
        $id = $this->input->post('id');
        $section = $this->input->post('section');
        $model = $this->load->model('someone_model');

        $this->someone_model->_id = $id;
        $this->someone_model->_section = $section;

        if($this->someone_model->delete_image()) {
            $data['json_data'] = array('success' => TRUE, 'id' => $id);
            $this->load->view('json', $data);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'An error occured while deleting image. Please try again.');
            $this->load->view('json', $data);
        }
    }

    public function sortOrderUpdate_ajax() {
        $data = $this->input->post('data');
        $section = $this->input->post('section');

        $this->load->model('someone_model');
        foreach($data as $d) {
            $this->someone_model->_id = $d['id'];
            $this->someone_model->_order = $d['order'];
            
            if(isset($section) && !empty($section)) {
                $this->someone_model->_section = $section;
            }

            if(isset($d['title']) && !empty($d['title'])) {
                $this->someone_model->_title = $d['title'];
            }
            
            if(isset($d['link']) && !empty($d['link'])) {
                $this->someone_model->_link = $d['link'];
            }
            
            $this->someone_model->update_order();
        }

        $data['json_data'] = array('success' => TRUE);
        $this->load->view('json', $data);
    }

    public function deleteSomeone_ajax() {
        $id = $this->input->post('id');
        $folder = $this->input->post('folder');
        $section = $this->input->post('section');
        
        $this->load->model('someone_model');
        $this->someone_model->_id = $id;
        $this->someone_model->_section = $section;
        $this->someone_model->_folder = $folder;

        if($this->someone_model->delete()) {
            $data['json_data'] = array('success' => TRUE);
            $this->load->view('json', $data);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'An error occured while deleting ' . substr($section, 0, -1) . '. Please try again.');
            $this->load->view('json', $data);
        }
    }

    public function deleteSlide_ajax() {
        $id = $this->input->post('id');
        
        $this->load->model('home_model');
        $this->home_model->id = $id;

        if($this->home_model->delete()) {
            $data['json_data'] = array('success' => TRUE);
            $this->load->view('json', $data);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'An error occured while deleting slide. Please try again.');
            $this->load->view('json', $data);
        }
    }

    public function addSlideDb_ajax() {
        $src = $this->input->post('src');
        $text = $this->input->post('text');
        $order = $this->input->post('order');
        $text_position = $this->input->post('text_position');
        $text_color = $this->input->post('text_color');
        $tempurl = $this->input->post('tempurl');

        $this->load->model('home_model');
        $this->home_model->src = $src;
        $this->home_model->text = $text;
        $this->home_model->order = $order;
        $this->home_model->text_position = $text_position;
        $this->home_model->text_color = $text_color;

        if($tempurl) {
            $strarr = explode('.', $tempurl);
            $ext = $strarr[count($strarr) - 1];
            $name = time() . "_" . md5(uniqid());
            
            $dir = realpath(APPPATH . '../img/home') . DS;

            while (file_exists($dir . $name . '.' . $ext)) {
                $name .= rand(10, 99);
            }

            $new_src = $name . '.' . $ext;

            if(file_exists($tempurl)) {
                if(!rename($tempurl, $dir . $new_src)) {
                    $data['json_data'] = array('success'=>FALSE, 'msg' => 'An error occured while saving the image.');
                    $this->load->view('json', $data);
                    return;
                }
            } else {
                $data['json_data'] = array('success'=>FALSE, 'msg' => 'Image file is not readable. Please upload a new one.');
                $this->load->view('json', $data);
                return;
            }

            if(file_exists($tempurl)) {
                unlink($tempurl);
            }

            $this->home_model->src = $new_src;
            $id = $this->home_model->insert();

            if($id !== 0) {
                $data['json_data'] = array('success' => TRUE, 'id' => $id, 'src' => $new_src);
                $this->load->view('json', $data);
            } else {
                unlink($dir . $new_src);

                $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to insert image into database.');
                $this->load->view('json', $data);
            }
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Image not available.');
            $this->load->view('json', $data);
        }
    }

    public function updateSlide_ajax() {
        $id = $this->input->post('id');
        $text = $this->input->post('text');
        $order = $this->input->post('order');
        $text_position = $this->input->post('text_position');
        $text_color = $this->input->post('text_color');

        $this->load->model('home_model');
        $this->home_model->id = $id;
        $this->home_model->text = $text;
        $this->home_model->order = $order;
        $this->home_model->text_position = $text_position;
        $this->home_model->text_color = $text_color;

        if($this->home_model->update()) {
            $data['json_data'] = array('success' => TRUE, 'id' => $id);
            $this->load->view('json', $data);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to update this slide.');
            $this->load->view('json', $data);
        }
    }

    public function updateSlideWithImg_ajax() {
        $id = $this->input->post('id');
        $src = $this->input->post('src');
        $text = $this->input->post('text');
        $order = $this->input->post('order');
        $text_position = $this->input->post('text_position');
        $text_color = $this->input->post('text_color');
        $tempurl = $this->input->post('tempurl');

        $this->load->model('home_model');
        $this->home_model->id = $id;
        $this->home_model->src = $src;
        $this->home_model->text = $text;
        $this->home_model->order = $order;
        $this->home_model->text_position = $text_position;
        $this->home_model->text_color = $text_color;
        
        if($tempurl) {
            $strarr = explode('.', $tempurl);
            $ext = $strarr[count($strarr) - 1];
            $name = time() . "_" . md5(uniqid());
            
            $dir = realpath(APPPATH . '../img/home') . DS;

            while (file_exists($dir . $name . '.' . $ext)) {
                $name .= rand(10, 99);
            }

            $new_src = $name . '.' . $ext;

            if(file_exists($tempurl)) {
                if(!rename($tempurl, $dir . $new_src)) {
                    $data['json_data'] = array('success'=>FALSE, 'msg' => 'An error occured while saving the image.');
                    $this->load->view('json', $data);
                    return;
                }
            } else {
                $data['json_data'] = array('success'=>FALSE, 'msg' => 'Image file is not readable. Please upload a new one.');
                $this->load->view('json', $data);
                return;
            }

            if(file_exists($tempurl)) {
                unlink($tempurl);
            }

            $this->home_model->src = $new_src;

            if($this->home_model->update_with_img()) {
                $data['json_data'] = array('success' => TRUE, 'src' => $new_src);
                $this->load->view('json', $data);
            } else {
                unlink($dir . $new_src);

                $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to update this slide.');
                $this->load->view('json', $data);
            }
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Image file is not readable. Please upload a new one.');
            $this->load->view('json', $data);
        }
    }

    public function deleteTempImg_ajax() {
        $url = $this->input->post('tempurl');

        if(file_exists($url)) {
            if(!unlink($url)) {
                $data['json_data'] = array('success' => FALSE, 'msg' => 'An error occured while deleting image. Please try again.');
                $this->load->view('json', $data);
            } else {
                $data['json_data'] = array('success' => TRUE);
                $this->load->view('json', $data);
            }
        } else {
            $data['json_data'] = array('success' => TRUE);
            $this->load->view('json', $data);
        }
    }

    public function deleteSlideImg_ajax() {
        $id = $this->input->post('id');
        $this->load->model('home_model');
        $this->home_model->id = $id;
        
        if($this->home_model->delete_img()) {
            $data['json_data'] = array('success' => TRUE);
            $this->load->view('json', $data);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'An error occured while deleting image. Please try again.');
            $this->load->view('json', $data);
        }
    }

    public function createNews_ajax() {
        $headline = $this->input->post('headline');
        $headline_cz = $this->input->post('headline_cz');
        $text = $this->input->post('text');
        $text_cz = $this->input->post('text_cz');
        $size = $this->input->post('size');

        $this->load->model('news_model');
        $this->news_model->headline = $headline;
        $this->news_model->headline_cz = $headline_cz;
        $this->news_model->text = $text;
        $this->news_model->text_cz = $text_cz;
        $this->news_model->size = $size;

        $id = $this->news_model->insert();
        
        if($id !== 0) {
            $data['json_data'] = array('success' => TRUE, 'id' => $id);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to insert this article into database.');
        }

        $this->load->view('json', $data);
    }

    public function updateNews_ajax() {
        $id = $this->input->post('id');
        $headline = $this->input->post('headline');
        $headline_cz = $this->input->post('headline_cz');
        $text = $this->input->post('text');
        $text_cz = $this->input->post('text_cz');
        $size = $this->input->post('size');

        $this->load->model('news_model');
        $this->news_model->id = $id;
        $this->news_model->headline = $headline;
        $this->news_model->headline_cz = $headline_cz;
        $this->news_model->text = $text;
        $this->news_model->text_cz = $text_cz;
        $this->news_model->size = $size;

        if($this->news_model->update()) {
            $data['json_data'] = array('success' => TRUE, 'msg' => 'Successfuly updated!');
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to update this article. Please try again.');
        }

        $this->load->view('json', $data);
    }

    public function deleteNews_ajax() {
        $id = $this->input->post('id');

        $this->load->model('news_model');
        $this->news_model->id = $id;

        if($this->news_model->delete()) {
            $data['json_data'] = array('success' => TRUE);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to delete this article. Please try again.');
        }

        $this->load->view('json', $data);
    }

    public function addNewsPhotoDb_ajax() {
        $src = $this->input->post('src');
        $order = $this->input->post('order');
        $news_id = $this->input->post('news_id');
        $tempurl = $this->input->post('tempurl');

        $this->load->model('news_model');
        $this->news_model->news_id = $news_id;
        $this->news_model->_order = $order;
        
        if($tempurl) {
            $strarr = explode('.', $tempurl);
            $ext = $strarr[count($strarr) - 1];
            $name = time() . "_" . md5(uniqid());
            
            $params['fileName'] = $tempurl;
            $this->load->library('image_resize', $params);
            
            
            
            $dir = realpath(APPPATH . '../img/newsImgs') . DS;

            while (file_exists($dir . $name . '.' . $ext)) {
                $name .= rand(10, 99);
            }

            $new_src = $name . '.' . $ext;
            
            list($src_w, $src_h) = getimagesize($tempurl);

            $ratio = $src_w / $src_h;
            $new_w = round(1080 * $ratio);

            if($src_h !== 1080) {
                $resized_image = new Image_resize($params);
                $resized_image->resizeImage($new_w, 1080, 'auto');
                $resized_image->saveImage($dir . $new_src, 90);    
            } else {
                if(!rename($tempurl, $dir . $new_src)) {
                    $data['json_data'] = array('success'=>FALSE, 'msg' => 'An error occured while saving the image.');
                    $this->load->view('json', $data);
                    return;
                }
            }

            $thumb_params['fileName'] = $dir . $new_src;
            $thumb = new Image_resize($thumb_params);
            $thumb->resizeImage(635, 766, 'crop');
            $thumb->saveImage($dir . 'thumbs/' . $new_src, 90);

            if (file_exists($tempurl)) {
                unlink($tempurl);
            }

            $this->news_model->src = $new_src;
            $id = $this->news_model->insert_img();

            if($id !== 0) {
                $data['json_data'] = array('success' => TRUE, 'id' => $id, 'src' => $new_src);
                $this->load->view('json', $data);
            } else {
                if(file_exists($dir . $new_src)) {
                    unlink($dir . $new_src);
                }

                $data['json_data'] = array('success' => FALSE, 'msg' => 'Failed to insert image into database.');
                $this->load->view('json', $data);
            }
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'Image not available.');
            $this->load->view('json', $data);
        }
    }

    public function deleteNewsImage_ajax() {
        $id = $this->input->post('id');
        $this->load->model('news_model');

        $this->news_model->id = $id;

        if($this->news_model->delete_image()) {
            $data['json_data'] = array('success' => TRUE, 'id' => $id);
            $this->load->view('json', $data);
        } else {
            $data['json_data'] = array('success' => FALSE, 'msg' => 'An error occured while deleting image. Please try again.');
            $this->load->view('json', $data);
        }
    }

}