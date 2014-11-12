<?php
    class Table_Model extends CI_Model
    {
        const DATABASE = 'uniquesnacks';
        
        function __construct()
        {
            parent::__construct();
        }   
        
        public function getTables()
        {
            $result = $this->db->query('Show tables from '.$this::DATABASE);
            return $result;
        }
        
        public function isTableEmpty($table)
        {
            $count =  $this->db->count_all($table);
            if($count == 0)
            {
                return true;
            }
            return false;
        }
        
        public function isTablePresent($table)
        {
            $result = $this->getTables();
            foreach ($result->result_array() as $row) {
                
                $indexedRow = array_values($row);
                
                if($indexedRow[0] == $table)
                {                    
                    return true;    
                }
            }
            return false;
        }
        
        public function createTableForSalary($tableName)
        {
            
            $sql = 'Create Table '. $tableName.' (
                    id INT(20),
                    incentive INT(10) DEFAULT 0,
                    PRIMARY KEY ( id )
                    );';    
            $return = $this->db->query($sql);
           
            return $return ;
        }
        //Test
        public function createTableForContact()
        {
            $sql = 'Create Table contact (
                    id INT(20)  AUTO_INCREMENT,
                    message varchar(1000),
                    email varchar(100),
                    name varchar(100),
                    PRIMARY KEY (id)
                    );';
            
            $return = $this->db->query($sql);
           
            return $return ;
        }
        
        
        
        
        public function createTableForChaining($tableName)
        {
            
            $sql = 'Create Table '. $tableName.' (
                    id INT(20),
                    introducer_id INT(20),
                    level_id INT(10) ,
                    PRIMARY KEY( id )
                    );';    
            $return = $this->db->query($sql);
           
            return $return ;
        }
        
        public function dropTable($tableName)
        {
            $this->db->query('Drop table '.$tableName);
        }
       
        public function getIncentiveFromLevelTable($level_id)
        {
            $result = $this->db->query('Select percentage_share from level where level_id = '.$level_id);
            $array = $result->result();
            return $array[0]->percentage_share;
        }
        
        public function cloneTable($oldTable, $newTable)
        {
            $this->db->query('CREATE TABLE '.$newTable.' SELECT * FROM '.$oldTable);
        }
        
        public function getName($id)
        {
            $result = $this->db->query('Select name from customer_info where id = '.$id);
            $name = $result->result();
            
            return $name[0]->name;
        }

        public function getPercentageShare($id)
        {
            $query = $this->db->query('Select percentage_share as share from level where level_id ='. $id);
            $result = $query->result();
            return $result[0]->share;
        } 
    }
?>