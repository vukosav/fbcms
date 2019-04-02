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
        $user_id =  $this->session->userdata('user')['user_id'];
        if (!empty($_FILES)) { 
        $tempFile = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $date = new DateTime();
        //$fileName = $date->getTimestamp().preg_replace("/[^\w\-\.]/", '',$_FILES['file']['name']); 
        $fileName = $date->getTimestamp().preg_replace("/[^\w\-\.]/", '',$fileName); 
       // if(!file_exists('./uploads/' . date('Y') . '/' .  date('M'). '/' . $this->session->userdata('user')['user_id'])){ 
       //      mkdir('./uploads/' . date('Y') . '/' . date('M') . '/' . $this->session->userdata('user')['user_id'], 0777, true);  
      //  }
        $user_upload_file_location = '/uploads/' . date('Y') . '/' . date('M') . '/' . $user_id . '/' ;  
        
        $targetPath = getcwd() . $user_upload_file_location ; 
        $targetFile = $targetPath .  $fileName ; 
        move_uploaded_file($tempFile, $targetFile); 
        echo  $fileName; 
        }
    }
    public function uploadVideo() {
        $user_id =  $this->session->userdata('user')['user_id'];
         $fileName = $_FILES['file']['name'];
         $fileType = $_FILES['file']['type'];
         $fileError = $_FILES['file']['error'];
         $fileTmpLoc = $_FILES['file']['tmp_name'];
         $user_upload_file_location = '/uploads/' . date('Y') . '/' . date('M') . '/' . $user_id. '/';
         $targetPath = getcwd() . $user_upload_file_location ;
         $targetFile = $targetPath .  $fileName ;
 
         move_uploaded_file($fileTmpLoc,$targetFile);
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
    // public function uploadVideo() {
    //    $user_id =  $this->session->userdata('user')['user_id'];
    //     $fileName = $_FILES['file']['name'];
    //     $fileType = $_FILES['file']['type'];
    //     $fileError = $_FILES['file']['error'];
    //     $fileContent = file_get_contents($_FILES['file']['tmp_name']);
    // //   if(!file_exists('/uploads/' . date('Y') . '/' .  date('M'). '/' . $user_id )){
    // //         // echo '3';
    // //         mkdir('/uploads/' . date('Y') . '/' . date('M') . '/' . $user_id , 0777, true); 
    // //       }
    
    //         $user_upload_file_location = '/uploads/' . date('Y') . '/' . date('M') . '/' . $user_id;
    //        //$user_upload_file_location = $this->input->post('uploadPath');    
    //         $targetPath = getcwd() . $user_upload_file_location ;
    
    //         $targetFile = $targetPath .  $fileName ;

    //     file_put_contents($targetFile, $fileContent);
    //     if($fileError == UPLOAD_ERR_OK){
    //         echo json_encode(array(
    //             'error' => false,
    //             'message' => 'OK',
    //             'fileName' => $fileName
    //             ));
    //     }else{
    //     switch($fileError){
    //         case UPLOAD_ERR_INI_SIZE:   
    //             $message = 'Error trying to upload a file that exceeds the allowed size.';
    //             break;
    //         case UPLOAD_ERR_FORM_SIZE:  
    //             $message = 'Error trying to upload a file that exceeds the allowed size.';
    //             break;
    //         case UPLOAD_ERR_PARTIAL:    
    //             $message = 'Error: no terminó la acción de subir el archivo.';
    //             break;
    //         case UPLOAD_ERR_NO_FILE:    
    //             $message = 'Error: the file upload action was not completed.';
    //             break;
    //         case UPLOAD_ERR_NO_TMP_DIR: 
    //             $message = 'Error: server not configured to upload files.';
    //             break;
    //         case UPLOAD_ERR_CANT_WRITE: 
    //             $message= 'Error: possible failure when recording the file.';
    //             break;
    //         case  UPLOAD_ERR_EXTENSION: 
    //             $message = 'Error: file upload not completed.';
    //             break;
    //         default: $message = 'Error: file upload not completed.';
    //                 break;
    //         }
    //         echo json_encode(array(
    //                 'error' => true,
    //                 'message' => $message,
    //                 'fileName' => $fileName
    //                 ));
    //     }
    // }
}
 
/* End of file dropzone.js */
/* Location: ./application/controllers/dropzone.php */