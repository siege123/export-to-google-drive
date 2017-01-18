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
class google_access_token_db extends CI_Model{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAccessToken($userid){
        $query = $this->db->get_where('dbName','userid = ' . $userid);
        return $query;
    }
    
    public function setAccessToken(array $data){
        $this->db->insert('dbName', $data);
    }
    
    public function updateAccessToken($userid, $accessToken){
        $this->db->where('userid', $userid);
        $this->db->update('access_token', $accessToken);
    }
}
