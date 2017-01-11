<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Users extends CI_Controller {
    
    
    public function __construct() {
        parent::__construct();
    }
    
    //load accounts
    public function index()
    {
        $this->load->helper('form');
        $this->load->model('Users_db');
        $data['accounts'] = $this->Users_db->getAccounts();
        $this->load->view('users/accounts', $data);

    }
    
    //create new account
    public function create(){
        $this->load->view('users/newAccount');
    }
    
    //insert account to database
    public function save(){

        $name = $this->input->post('name');
        $address = $this->input->post('address');
        $this->load->model('Users_db');
        $data['newAccount'] = array(
            'name' => $name,
            'address' => $address
        );

        $this->Users_db->insert_account($data['newAccount']);

        redirect("users/");

    }

    //delete account 
    public function delete($id){
        $this->load->model('Users_db');
        $this->Users_db->delete_account($id);
        redirect("/users/");
    }

    //load new inserted data
    public function info($id, $name, $address){
        $data['name'] = $name;
        $data['address'] = $address;
        $data['id'] = $id;
        $this->load->view('users/updateAccount', $data);    
    }
    
    //update account
    public function update(){
        $name = $this->input->post('name');
        $address = $this->input->post('address');
        $id = $this->input->post('id');

        $this->load->model('Users_db');

        $data['updateAccount'] = array(
            'id'        => $id,
            'name'      => $name,
            'address'   => $address               
        );

        $this->Users_db->update_account($data['updateAccount'], $id);
        redirect("/users/");
    }
    

    public function generateExcel($validation){
        //FIRST GENERATE THE EXCEL USING PHPExcel
        $this->load->library('Excel');
        $objPHPExcel = new PHPExcel();
        
        $objPHPExcel->getProperties()->setCreator("CJ Llave")
                                    ->setLastModifiedBy("CJ Llave")
                                    ->setTitle("Account Information (test)")
                                    ->setSubject("Account Information")
                                    ->setDescription("test document")
                                    ->setKeywords("office 2007 openxml php")
                                    ->setCategory("Test result file");
        
        $this->load->model('Users_db');
        $data['info'] = $this->Users_db->getAccounts();
        $i = 2;
        $this->load->library('excel');

        $this->excel->setActiveSheetIndex(0);
        
        $this->excel->getActiveSheet()->setCellValue('A1', 'Name');
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->setCellValue('B1', 'Address');
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(10);
        $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
        
        foreach($data['info'] as $account){            
            $this->excel->getActiveSheet()->setCellValue('A'.$i , $account['name']);
            $this->excel->getActiveSheet()->getStyle('A'.$i )->getFont()->setSize(10);
            $this->excel->getActiveSheet()->setCellValue('B'.$i , $account['address']);
            $this->excel->getActiveSheet()->getStyle('B'.$i )->getFont()->setSize(10);
            $i++;
        }

        $filename = 'accountInfo.xls';
        
        
        //read file or download
        if($validation == 'read'){
            //REDIRECT TO ANOTHER FUNCTION
            $this->readFile($filename);
            
        }else if($validation == 'dl'){
            
            //SPECIFY HEADERS AND THE DIRECTORY WHERE TO SAVE THE EXCEL FILE
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename='.$filename);
            header('Cache-Control: max-age=0');
        
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');  
            $objWriter->save('php://output');            
        }
                
    }
    
    
    function saveTo(){
        
        $this->load->view('users/save');
    }
    
    //READS THE FILE (RETRIEVED MANUALLY AND USING A STATIC FILENAME CALLED ACCOUNTINFO.XLS)
    function readFile($filename){
        $url = '/home/codeninja/Desktop/cj.com/'.$filename;        
        
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($url);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        echo '<table>' . "\n";
        foreach ($objWorksheet->getRowIterator() as $row) {
            echo '<tr>' . "\n";
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach ($cellIterator as $cell) {
                echo '<td>' . $cell->getValue() . '</td>' . "\n";
            }
            echo '</tr>' . "\n";
            
        }
        
        //BACK BUTTON
        echo '</table>' . "\n";
        echo '<button onclick="goBack()"> Back </button></a>';
        echo '<script>';
        echo 'function goBack(){';
        echo '  window.history.back()';
        echo '}';
        echo '</script>';
    
        echo '<style>'; 
        echo 'body {';
             echo 'background: #2c3338;';
             echo 'color: #ffffff;';
             echo 'font: 87.5%/1.5em \'Open Sans\', \'sans-serif;\'';
             echo 'margin: 0;';
             echo '\'}\'';
        echo '</style>';
        
        
    }
    
    //amp test
    public function amp(){
        $this->load->view('users/ampTest');
    }
      
}
 
