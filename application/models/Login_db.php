<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users_Db
 *
 * @author codeninja
 */
class Login_db extends CI_Model{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    //select
    public function getAccounts($name, $pass){
        $query = $this->db->get_where('login_account', array('username' => $name, 'password' => $pass));
        return $query->result_array();
    }
    
}
