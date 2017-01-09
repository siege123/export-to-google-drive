<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Upload_to_drive
 *
 * @author codeninja
 */
class Upload_to_drive extends CI_Controller{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $this->load->helper('form');
        $this->load->view('users/save2');
    }
    
    public function auth(){
        $this->load->library('session');
        $this->load->helper('form');
        
        $redirect_uri = 'http://www.cj.com' . '/upload_to_drive/auth';
        $client = new Google_Client();
        $client->setAuthConfig('/home/codeninja/Desktop/cj.com/client_secret.json');
        $client->setRedirectUri($redirect_uri);
        $client->addScope("https://www.googleapis.com/auth/drive");
        
        $code = $this->input->post_get('code');
        
        if(isset($code)){
            $token = $client->fetchAccessTokenWithAuthCode($code);
            $client->setAccessToken($token);
            
            $this->session->set_userdata('upload_token');
            
            $data['accessToken'] = $client->getAccessToken();            
            
            $filename = $this->input->post('nameOfFile');
            
            if(empty($filename)){
                $filename = 'sample';
            }
            
            $this->uploadFile($filename, $client);
            
        }
        
        if(!empty($this->session->upload_token)){
            $client->setAccessToken($this->session->upload_token);
            
            if($client->isAccessTokenExpired()){
                $this->session->unset_userdata('upload_token');
            }
            
        }else{
            redirect($client->createAuthUrl());
        }
    }
    
    public function uploadFile($filename, $client){
        $this->load->helper('form');
        $file = new Google_Service_Drive_DriveFile();
        $service = new Google_Service_Drive($client);
        
        $file->setName($filename);
        $file->setMimeType('application/vnd.ms-excel');
        $file->setDescription('test document');        
        
        try {
            //considering that the file to be uploaded is in the said directory
            $data = file_get_contents('/home/codeninja/Desktop/cj.com/accountInfo.xls');

            $createdFile = $service->files->create($file, array(
                'data' => $data,
                'mimeType' => 'application/vnd.ms-excel',
            ));
            
            $this->load->view('users/uploadSuccess');
        
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        } 
    }

}
