<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NewEntry extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();    
    }
    
    public function index()
    {
        echo("hi a gaya bhai yahan to");
    }
    
    public function login()
    {
        echo '<h2>Unique Snacks</h2>';
        $this->load->view('new/customer1');
    }
    
    public function callback()
    {
 	
        $this->load->model('New_record_entry');
        
        //checking if the introducer key is not 0 i.e. company.
        if($_POST['introducer_id'] !== '0')
        {
            //checking if introducer with the specified name & id already present or not
            if($this->New_record_entry->ifIntroducerPresent($_POST['introducer_id'], $_POST['introducer_name']) == false)
            {
                $this->load->view('new/error_message', array(
                        'message'=> $_POST['introducer_id'].' or '.$_POST['introducer_name'] .' are not valid.' 
                                                        ));
                return;
            }
            
        }
        
        $this->load->library('Date_Model');
        $currentDate = new Date_Model();
        $currentDate->set_date($_POST['doj']);
        echo $currentDate;
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        $table = ''.$currentDate.'_salary';
        if($tableModel->isTablePresent($table) && !$tableModel->isTableEmpty($table))
        {
             $this->load->view('new/error_message', array(
                        'message'=> 'data already generated<br>Contact Admin' 
                                                        ));
                return;
        }
        
        
        $obj = new New_record_entry(); 
        
        $obj->doj=date($_POST['doj']);
        
        $obj->name = $_POST['name'];
        $obj->husband_fathername=$_POST['husband_fathername'];
        $obj->sex=$_POST['sex'];
        $obj->dob=date($_POST['dob']);
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
        $obj->introducer_name=$_POST['introducer_name'];
        $obj->introducer_id=$_POST['introducer_id'];
        $obj->account_no=$_POST['account_no'];
        $obj->name_of_bank=$_POST['name_of_bank'];
        $obj->name_of_branch=$_POST['name_of_branch'];
        
        $obj->save();
     
        $this->load->view('new/success_message', array('message' => "Entry has been inserted successfully.<br>
                                                                     Please Note id for referal : ". $obj->id));
    }
}