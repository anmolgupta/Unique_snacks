<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NewEntry extends CI_Controller {
    
    const COMPANY_ID = '1';
    public function __construct()
    {
        parent::__construct();    
    }
    
    public function login()
    {
        $this->load->view('mainpage/header');   
        $this->load->view('new/form');
        $this->load->view('mainpage/footer');      
    }
   
    public function callback()
    {
        $this->load->model('New_record_entry');
        
        $introducer_name = trim($_POST['introducer_name']);
        //checking if the introducer key is not 0 i.e. company.
        if($_POST['introducer_id'] !== $this::COMPANY_ID)
        {
            //checking if introducer with the specified name & id already present or not
            $record = $this->New_record_entry->getRecord($_POST['introducer_id']);
            if($record == false || strcasecmp($introducer_name, $record->name) !== 0)
            {
                $this->load->view('mainpage/header');
                $this->load->view('new/error_message', array(
                        'message'=> 'Introdecer ID: '.$_POST['introducer_id'].'<br>Introducer Name: '.$_POST['introducer_name'] .' <br>doesnot match.' 
                                                        ));
                $this->load->view('mainpage/footer');
                return;
            }
        }
        else
        if($_POST['introducer_id'] == $this::COMPANY_ID)
        {
            if(strcasecmp($introducer_name, 'Unique Snacks') !== 0)
            {
                $this->load->view('mainpage/header');
                $this->load->view('new/error_message', array(
                        'message'=> 'Introdecer ID: '.$_POST['introducer_id'].'<br>Introducer Name: '.$_POST['introducer_name'] .' <br>doesnot match.' 
                                                        ));
                $this->load->view('mainpage/footer');
                return;
            }
        }
        
        $this->load->library('Date_Model');
        $currentDate = new Date_Model();
        $currentDate->set_date($_POST['doj']);
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        $table = 'salary_'.$currentDate;
        if($tableModel->isTablePresent($table))
        {
             $this->load->view('mainpage/header');
             $this->load->view('new/error_message', array(
                                                'message'=> 'Cannot Perform Operation as Data for '.$currentDate->getCurrentMonth().', '.$currentDate->year.' 
                        has already been generated.<br>Contact Admin' 
                                                        ));             
             $this->load->view('mainpage/footer');         
             return;
        }
        
        
        $obj = new New_record_entry(); 

        $obj->doj = date("Y-m-d", strtotime($_POST['doj']));
        
        $obj->name = trim($_POST['Name']);
        $obj->husband_fathername=$_POST['husband_fathername'];
        $obj->sex=$_POST['sex'];
        $obj->dob = date("Y-m-d", strtotime($_POST['dob']));
        $obj->place_of_birth=$_POST['place_of_birth'];
        $obj->marital_status=$_POST['marital_status'];
        $obj->nationality=$_POST['nationality'];
        $obj->pan_no=$_POST['pan_no'];
        $obj->address=$_POST['address'];
        $obj->city=$_POST['city'];
        $obj->pincode=$_POST['pincode'];
        $obj->phone_no=$_POST['phone_no'];
        $obj->mobile_no=$_POST['mobile_no'];
        $obj->nominee_name=$_POST['nominee_name'];
        $obj->relationship_with_nominee=$_POST['relationship_with_nominee'];
        $obj->joining_fee=$_POST['joining_fee'];
        $obj->introducer_id=$_POST['introducer_id'];
        $obj->account_no=$_POST['account_no'];
        $obj->name_of_bank=$_POST['name_of_bank'];
        $obj->name_of_branch=$_POST['name_of_branch'];
        
        $obj->save();
        
        $this->load->view('mainpage/header');   
        $this->load->view('new/success_message', array('message' => "Entry has been inserted successfully.<br>
                                                                     Please Note id for referal : ". $obj->id));
        $this->load->view('mainpage/footer');

    }

    public function search()
    {
        $id = $_POST['user'];
        $this->load->model('New_record_entry');
        
            //checking if introducer with the specified name & id already present or not
            $record = $this->New_record_entry->getRecord($id);
            if($record == false)
            {
                $this->load->view('mainpage/header');
                $this->load->view('new/error_message', array(
                        'message'=> 'ID: '.$id.'  not Present.' 
                                                        ));
                $this->load->view('mainpage/footer');
                return;
            }
            
            //loading the page with the content;
            $record->doj = date("d-m-Y", strtotime($record->doj));
            $record->dob = date("d-m-Y", strtotime($record->dob));
            
            $this->load->view('mainpage/header');
            $this->load->view('mainpage/display_record', array(
                                                             'record'=>$record
                                                              ));
            $this->load->view('mainpage/footer');
                    
    }
    
    
    public function update()
    {
        $id = $_POST['user'];
        $this->load->model('New_record_entry');
        
            //checking if introducer with the specified name & id already present or not
            $record = $this->New_record_entry->getRecord($id);
            if($record == false)
            {
                $this->load->view('mainpage/header');
                $this->load->view('new/error_message', array(
                        'message'=> 'ID: '.$id.' not present.' 
                                                        ));
                $this->load->view('mainpage/footer');
                return;
            }
            $record->doj = date("d-m-Y", strtotime($record->doj));
            $record->dob = date("d-m-Y", strtotime($record->dob));
            $this->load->view('mainpage/header');
            $this->load->view('mainpage/update_record', array(
                                                             'record'=>$record
                                                              ));
            $this->load->view('mainpage/footer');
        
    }
    
    public function delete()
    {
        $id = $_POST['user'];
        $this->load->model('New_record_entry');
        
        //checking if introducer with the specified name & id already present or not
        $record = $this->New_record_entry->getRecord($id);
        if($record == false)
        {
            $this->load->view('mainpage/header');
            $this->load->view('new/error_message', array(
                                                    'message'=> 'ID: '.$id.' not present.' 
                                                       ));
            $this->load->view('mainpage/footer');
            return;
        }
        
        $record->doj = date("d-m-Y", strtotime($record->doj));
        $record->dob = date("d-m-Y", strtotime($record->dob));
        $this->load->view('mainpage/header');
        $this->load->view('mainpage/delete_record', array(
                                                      'record'=>$record
                                                          ));
        $this->load->view('mainpage/footer');
    }
    
    public function delete_callback()
    {
        $id =$_GET['id'];
        $doj = $_GET['doj'];
        $name = $_GET['name'];    
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date($doj);
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        $this->load->model('New_record_entry');
        
          
          if($this->New_record_entry->getRecordRelatedToIntroducer($id) > 0)
          {
                $this->load->view('mainpage/header');
                $this->load->view('new/error_message', array(
                        'message'=> 'This record has some related records in database'
                                                        ));
                $this->load->view('mainpage/footer');             
                return;
          }
        
        if($tableModel->isTablePresent('salary_'.$currentMonth))
        {
             $this->load->view('mainpage/header');
             $this->load->view('new/error_message', array(
                        'message'=> 'Cannot Perform Operation as Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.' 
                        has already been generated.<br>Contact Admin' 
                                                        ));
             $this->load->view('mainpage/footer');             
             return;
        }
        
        $this->New_record_entry->delete_record($id);
        
        $this->load->view('mainpage/header');
        $this->load->view('new/error_message', array(
                                             'message'=> $name.' ('.$id.') <br> DELETED SUCCESSFULLY' 
                                                       ));
        $this->load->view('mainpage/footer');
    }
    
    public function update_callback()
    {
        $id = $_POST['id'];
        
        $this->load->model('New_record_entry');
        
        $record = $this->New_record_entry->getRecord($id);
        
        if($record->introducer_id == $_POST['introducer_id'] && $record->doj == date("Y-m-d", strtotime($_POST['doj'])))
        {
            $obj = new New_record_entry(); 
            $obj->id = $id;
            $obj->doj = date("Y-m-d", strtotime($_POST['doj']));
            
            $obj->name = trim($_POST['Name']);
            $obj->husband_fathername=$_POST['husband_fathername'];
            $obj->sex=$_POST['sex'];
            $obj->dob = date("Y-m-d", strtotime($_POST['dob']));
            $obj->place_of_birth=$_POST['place_of_birth'];
            $obj->marital_status=$_POST['marital_status'];
            $obj->nationality=$_POST['nationality'];
            $obj->pan_no=$_POST['pan_no'];
            $obj->address=$_POST['address'];
            $obj->city=$_POST['city'];
            $obj->pincode=$_POST['pincode'];
            $obj->phone_no=$_POST['phone_no'];
            $obj->mobile_no=$_POST['mobile_no'];
            $obj->nominee_name=$_POST['nominee_name'];
            $obj->relationship_with_nominee=$_POST['relationship_with_nominee'];
            $obj->joining_fee=$_POST['joining_fee'];
            $obj->introducer_id=$_POST['introducer_id'];
            $obj->account_no=$_POST['account_no'];
            $obj->name_of_bank=$_POST['name_of_bank'];
            $obj->name_of_branch=$_POST['name_of_branch'];
            
            $obj->update();
            
            $this->load->view('mainpage/header');   
            $this->load->view('new/error_message', array(
                                                    'message' => $id.' successfully updated.'
                                                        ));
            $this->load->view('mainpage/footer');
            return;
        }
        
        $this->load->library('Date_Model');
        $currentDate = new Date_Model();
        $currentDate->set_date($_POST['doj']);
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        $table = 'salary_'.$currentDate;
        
        if($tableModel->isTablePresent($table))
        {
             $this->load->view('mainpage/header');
             $this->load->view('new/error_message', array(
                        'message'=> 'Cannot Perform Operation as Data for '.$currentDate->getCurrentMonth().', '.$currentDate->year.' 
                        is not present.
                                     <br>Cannot change Introducer ID and the Joining Date.
                                     <br>Contact Admin' 
                                                        ));             
             $this->load->view('mainpage/footer');         
             return;
        }
    }
}