<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mainpage extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();    
    }
    
    public function index()
    {  
        $this->load->view('mainpage/header');
        $this->load->view('mainpage/main_page');  
        $this->load->view('mainpage/footer');  
    }
    
    public function customer_info_menu()
    {
        $this->load->view('mainpage/header');
        $this->load->view('mainpage/customer_info_menu');
        $this->load->view('mainpage/footer');  
    }
      
    public function display_monthly_menu()
    {
        $this->load->view('mainpage/header');
        $this->load->view('mainpage/display_monthly_menu');
        $this->load->view('mainpage/footer');  
    }
      
    public function calculate_salary_menu()
    {
        $this->load->view('mainpage/header');
        $this->load->view('mainpage/calculate_salary_menu');
        $this->load->view('mainpage/footer');  
    }  
    
 
}