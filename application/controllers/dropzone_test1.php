<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dropzone extends CI_Controller {
  
    public function __construct() {
       parent::__construct();
       $this->load->helper(array('url','html','form')); 
    }
 
    public function index() {
        $this->load->view('dropzone_view');
    }
    
    public function upload() {
        if (!empty($_FILES)) {
        $tempFile = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $targetPath = getcwd() . '/uploads/';
        
        $targetFile = $targetPath .  $fileName ;

        move_uploaded_file($tempFile, $targetFile);

        //this returns $fileName to caller function!!!
        echo  $fileName;
        // if you want to save in db,where here
        // with out model just for example
        // $this->load->database(); // load database
        // $this->db->insert('file_table',array('file_name' => $fileName));
        }
    }

    public function uploadVideo() {
        $fileName = $_FILES['file']['name'];
        $fileType = $_FILES['file']['type'];
        $fileError = $_FILES['file']['error'];
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);
        $targetPath = getcwd() . '/uploads/';
        
        $targetFile = $targetPath .  $fileName ;

        file_put_contents($targetFile, $fileContent);
        if($fileError == UPLOAD_ERR_OK){
            echo json_encode(array(
                'error' => false,
                'message' => 'OK',
                'fileName' => $fileName
                ));
        }else{
        switch($fileError){
            case UPLOAD_ERR_INI_SIZE:   
                $message = 'Error trying to upload a file that exceeds the allowed size.';
                break;
            case UPLOAD_ERR_FORM_SIZE:  
                $message = 'Error trying to upload a file that exceeds the allowed size.';
                break;
            case UPLOAD_ERR_PARTIAL:    
                $message = 'Error: no terminó la acción de subir el archivo.';
                break;
            case UPLOAD_ERR_NO_FILE:    
                $message = 'Error: the file upload action was not completed.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR: 
                $message = 'Error: server not configured to upload files.';
                break;
            case UPLOAD_ERR_CANT_WRITE: 
                $message= 'Error: possible failure when recording the file.';
                break;
            case  UPLOAD_ERR_EXTENSION: 
                $message = 'Error: file upload not completed.';
                break;
            default: $message = 'Error: file upload not completed.';
                    break;
            }
            echo json_encode(array(
                    'error' => true,
                    'message' => $message,
                    'fileName' => $fileName
                    ));
        }
    }
}
 
/* End of file dropzone.js */
/* Location: ./application/controllers/dropzone.php */