<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of google_access_token_db
 *
 * @author codeninja
 */
class Google_token_db extends CI_Model{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAccessToken($userId){
        $this->db->where('userId = ' . $userId);
        $qt = $this->db->get('google_token', 'access_token');

        $row = $qt->row_array();

        if ($row){
            $token = json_decode($row['access_token']);
        }
        else {
            $token = "";
        }
        return $token;
    }
    
    public function getRefreshToken($userId){
        $this->db->where('userId = ' . $userId);
        $qt = $this->db->get('google_token', 'refresh_token');

        $row = $qt->row_array();

        if ($row){
            $refreshToken = $row['refresh_token'];
        }
        else {
            $refreshToken = "";
        }
        return $refreshToken;
    }
    
    public function setToken($clientid, $token, $refreshToken, $userId, $googleCode){
        
        $result = $this->db->get_where('google_token',array('clientid' => $clientid, 'userId' => $userId));
        $row = $result->row_array();

        if(empty($row)){
            $db['clientid'] = $clientid;
            $db['access_token'] = json_encode($token);
            $db['refresh_token'] = $refreshToken;
            $db['userId'] = $userId;
            $db['authCode'] = $googleCode;
            $this->db->insert('google_token', $db);
        }
        else{
                $data = array(
                  'clientid' => $clientid,
                  'access_token' => json_encode($token),
                  'refresh_token' => $refreshToken,
                  'userId' => $userId,
                  'authCode' => $googleCode
               );

            $this->db->where('userId', $userId);
            $this->db->update('google_token', $data); 
        }
    }
    
    public function updateAccessToken($clientid, $userId, $accessToken){
        $data = array(
                  'clientid' => $clientid,
                  'userId' => $userId
               );
        $token = array('access_token' => $accessToken);
            $this->db->where($data);
            $this->db->update('google_token',$token); 
    }
    
    public function getUserId($userId){
        $this->db->where('userId = ' . $userId);
        $qt = $this->db->get('google_token', 'userId');

        $row = $qt->row_array();

        if ($row){
           $id = $row['userId'];
        }
        else {
            $id = "";
        }
        return $id;
    }
    
    public function getClientId($clientid){
        $this->db->where('clientid = ' . $clientid);
        $qt = $this->db->get('google_token', 'clientid');

        $row = $qt->row_array();

        if ($row){
           $id = $row['clientid'];
        }
        else {
            $id = "";
        }
        return $id;
    }
    
    public function getAuthCode($clientid, $userid){
        $this->db->where(array('clientid' => $clientid, 'userId' => $userid));
        $qt = $this->db->get('google_token', 'authCode');

        $row = $qt->row_array();

        if ($row){
           $code = $row['authCode'];
        }
        else {
            $code = "";
        }
        return $code;
    }
    
    public function deleteToken($userId, $clientid){
        $this->db->where(array('userId' => $userId, 'clientid' => $clientid));
        $this->db->delete('google_token');
    }
    
}

