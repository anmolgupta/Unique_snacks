<?php
    class Salary_Model extends CI_Model
    {
        const DB_TABLE_PK = 'id';
        public $id, $incentive;
        
        function __construct()
        {
            parent::__construct();
        }   
        
        public function save($table)
        {
            $result = $this->ifAlreadyPresent($table);
            if($result == false)
            {
                $this->db->insert($table, $this);
            }
            else
            {
                $result->incentive = $result->incentive + $this->incentive;
                //$this->db->update($table, $result, $this::DB_TABLE_Pk);
                $this->db->query('UPDATE '.$table.' 
                                SET incentive = '.$result->incentive.'
                                WHERE id = '.$result->id);
            }
        }
        
        public function ifAlreadyPresent($table)
        {
            $query  = $this->db->query('Select * from '.$table.' where '.$this::DB_TABLE_PK.' = '.$this->id);
            
            if($query->num_rows == 0)
            {
                return false;
            }
            
            $result = $query->result();
            
            $class = get_class($this);
            $obj = new $class;
            $obj->populate($result[0]);
            return $obj;
            
        }
        
        public function populate($row) 
        {
               foreach ($row as $key => $value) 
               {
                    $this->$key = $value;
               }
        }

        public function getTableRecordsWithAccountDetails($tableName)
        {
            $result = $this->db->query('Select table1.*, table2.account_no, table2.name_of_bank, table2.name  
                                       From '.$tableName.' as table1
                                       JOIN customer_info as table2
                                       ON table1.id=table2.id');
            return $result;
        }        
    }
