<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Magazine extends CI_Controller {
    
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
        echo $this->input->post('marital_status');
        $this->load->view('new/customer');
    }
}