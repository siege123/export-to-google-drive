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
class Users_db extends CI_Model{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    //select
    public function getAccounts(){
        $query = $this->db->get('users');
        return $query->result_array();
    }
    
    public function insert_account(array $data){
        $this->db->insert('users', $data);
    }
    
    public function delete_account($id){
        $this->db->delete('users', array('id' => $id));
        
    }
    
    public function update_account(array $data, $id){
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        
    }
}
