<?php

    class Contact_Us_Model extends CI_Model
    {
        const DB_TABLE = 'contact';
        const DB_TABLE_PK = 'id';
        public $id,$name, $email, $message;
        
        function __construct()
        {
            parent::__construct();
        }   
        
        public function save()
        {
            $this->db->insert($this::DB_TABLE, $this);
            $this->{$this::DB_TABLE_PK} = $this->db->insert_id();
        }
        
        public function get($id)
        {
            $result = $this->db->query('Select message from contact where id = '.$id);
            $row =  $result->result();
            return $row[0]->message;
        }
    }