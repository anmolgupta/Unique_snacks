<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_Us extends CI_Controller {
    
    
    public function __construct()
    {
        parent::__construct();    
    }
    
    public function viewForm()
    {
        $this->load->view("new/contact_us");
    }
    
    public function form_callback()
    {
        $this->load->model('Table_Model');
        $table_model = new Table_Model();
        
        if(!$table_model->isTablePresent("contact"))
        {
            $table_model->createTableForContact();
        }
        
        $this->load->model('Contact_Us_Model');
        $obj = new Contact_Us_Model();
        $obj->name = $_POST['Name'];
        $obj->message = $_POST['message'];
        $obj->email = $_POST['email'];
        try{
            $obj->save();
            $this->load->view("new/contact_us_callback", array('id' => $obj->id));
        }
        catch(Exception $e)
        {
            $this->load->voew("new/errorPage", array('message'=> 'The message was unable to send.'));
        }
    }

public function generateChars()
{
    $char = '';
    for($i = 0; $i< 1000; $i++)
    {
        $char .='a';
    }
    $this->load->view('new/errorPage', array('message'=>$char));
}

public function get()
{
    $this->load->model('Contact_Us_Model');
    $result = $this->Contact_Us_Model->get(4);
    echo $result."\n".strlen($result);
    
    
}
}