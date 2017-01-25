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
        $this->load->library('session');
        $this->load->helper('form','url');
        
        $redirect_uri = 'http://www.cj.com' . '/upload_to_drive';
        $client = new Google_Client();
        $client->setAuthConfig('/home/codeninja/Desktop/cj.com/client_secret.json');
        $client->setRedirectUri($redirect_uri);
        $client->addScope("https://www.googleapis.com/auth/drive");
        $client->addScope("https://www.googleapis.com/auth/plus.login");
        $client->setIncludeGrantedScopes(TRUE);
        $client->setAccessType('offline');
        
        //$client->setApprovalPrompt('force');

        if (isset($_GET['code'])) {
            $googleCode = $_GET['code'];
        }
        
        if(isset($_GET['error'])){
            print_r($_GET['error']); exit;
        }
        

//        if (isset($googleCode)) {
//                $clientid = 1234;
//                $this->load->model('Google_token_db');
//                $tokenData = $this->Google_token_db->getAccessToken($clientid);
//
//
//                if (!empty($tokenData)) {
//                    $token = json_decode(json_encode($tokenData), TRUE);                       
//                }
//                else {
//                    $token = $client->fetchAccessTokenWithAuthCode($googleCode);
//                }
//
//                if ($client->isAccessTokenExpired()) {
//                    $token = $client->fetchAccessTokenWithAuthCode($googleCode);
//                }
//
//                $client->setAccessToken($token);                        
//                $tk = $client->getAccessToken();
//                
//                $this->Google_token_db->setAccessToken($clientid, $tk);
//                $this->uploadFile($client);
//        }
//        else if(isset($googleError)){
//            echo "error"; die();
//        }else{
//            redirect($client->createAuthUrl());
//        }
        
        if(isset($googleCode))
        {
            $this->load->model('Google_token_db');

            $clientid = 1235;
            
            //get the tokens
            $token = $client->fetchAccessTokenWithAuthCode($googleCode);
            
            $client->setAccessToken($token);
            $accessToken = $client->getAccessToken();
            
            //print_r($accessToken);
            $userInfo =new Google_Service_Oauth2($client);
            $userId = $userInfo->userinfo_v2_me->get()->id;
            
            //get existing userid in db
            $dbUserId = $this->Google_token_db->getUserId($userId);

            //print_r($userId); 
            //print_r($dbUserId); exit;
            //if first authentication / or the user remove the permission
            if(isset($accessToken['refresh_token']))
            {                
                $refreshToken = $accessToken['refresh_token'];                               
                $this->Google_token_db->setToken($clientid, $accessToken, $refreshToken, $userId, $googleCode);
                $this->uploadFile($client);
            }
            
            $cid = $this->Google_token_db->getClientId($clientid);
            if(empty($cid)){
                $refreshToken = $this->Google_token_db->getRefreshToken($userId);
                $this->Google_token_db->setToken($clientid, $accessToken, $refreshToken, $userId, $googleCode);
            }
            //check if userid exists in db
            if(!empty($dbUserId)){
                $tokenData = $this->Google_token_db->getAccessToken($userId);                
                $this->setAccessToken($client, $tokenData, $userId, $clientid, $googleCode);        
            }   
            
            
            
        }else
        {
            redirect($client->createAuthUrl());
        }
        

    }
    
    public function setAccessToken($client, $tokenData, $userId, $clientid){
        
        $this->load->model('Google_token_db');
        
        //existing tokenData / expect it to have a data
        if(!empty($tokenData)){
            
            $token = json_encode($tokenData);
            $client->setAccessToken($token);

            //circumstances like expired or not valid
            if($client->isAccessTokenExpired())
            {
                $refreshToken = json_encode($tokenData);
                $client->setAccessToken($refreshToken);
                //$this->Google_token_db->updateAccessToken($clientid, $userId, $token);                                        $
            }                     
            $this->session->set_userdata('googleStatus', 'Success');
            $this->uploadFile($client);
   
            
        }else{
            print "an error occured. tokenData returned no value";
        }            
        
    }
    
    
    public function uploadFile($client){
        $this->load->helper('form');
        $file = new Google_Service_Drive_DriveFile();
        $service = new Google_Service_Drive($client);
        
        $file->setName('Untitled');
        $file->setMimeType('application/vnd.ms-excel');
        $file->setDescription('test document');        
        
        try {
            //considering that the file to be uploaded is in the said directory
            $data = file_get_contents('/home/codeninja/Desktop/cj.com/accountInfo.xls');

            $createdFile = $service->files->create($file, array(
                'data' => $data,
                'mimeType' => 'application/vnd.ms-excel',
            ));
        
            
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
        redirect('users');
    }

}