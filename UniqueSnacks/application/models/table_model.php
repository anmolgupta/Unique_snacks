<?php
    class Table_Model extends CI_Model
    {
        const DATABASE = 'laravel';
        
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
            $count =  $this->db->count_all($table);;
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
        
        public function createTableForChaining($tableName)
        {
            
            $sql = 'Create Table '. $tableName.' (
                    id INT(20),
                    chain VARCHAR(200),
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
        
        public function calculateSalary($chainingTable,$month, $year)
        {
            $result = $this->db->query('SELECT table1.chain as chain, table2.joining_fee as amount
                            FROM '.$chainingTable.' as table1
                            JOIN customer_info as table2
                            ON table1.id=table2.id 
                            where month(table2.doj) in('.$month.') and year(table2.doj) in('.$year.')');
            return $result;
        }
    }
?>