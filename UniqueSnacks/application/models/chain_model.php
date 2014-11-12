<?php
    class Chain_Model extends CI_Model
    {   
        public $id, $level_id, $introducer_id;
        const min_number = 9;
        
        function __construct()
        {
            parent::__construct();
        }   
        
        public function updateTable($tableName, $row)
        {
                $this->db->query('UPDATE '.$tableName.' 
                                  set level_id = '.$row->level_id.' ,
                                  introducer_id = '.$row->introducer_id.' 
                                  where id = '.$row->id);
        }
        
        public function getRecordsHavingLevel2($table)
        {
            $result = $this->db->query('Select * from '.$table.' where level_id = 2');
            return $result;
        }
        
        public function getIncentive($table, $id)
        {
            $result = $this->db->query('Select level.percentage_share as share, introducer_id, id 
                              from level 
                              JOIN '.$table.' as table2
                              ON level.level_id=table2.level_id 
                              where table2.id = '.$id);
            $rows = $result->result();
            return $rows[0];
        }
        
        public function getMonthlyChainedData($table, $month, $year)
        {
            $result = $this->db->query('SELECT table1.id, table1.introducer_id, table1.level_id, table2.joining_fee as amount 
                                        FROM '.$table.' as table1 
                                        JOIN customer_info as table2
                                        ON table1.id=table2.id
                                        WHERE MONTH(doj) = '.$month.' And YEAR(DOJ) = '.$year);    
            return $result;
        }
        
        public function getIDSet($table)
        {
            $result  = $this->db->query('Select * from '.$table);
            return $result;
        }
        
        public function insert($table, $row)
        {
            $this->db->insert($table,$row);
        }
        
        public function getLevel($table, $id)
        {
            $query = $this->db->query('Select * from '.$table.' where id = '.$id);
            
            if($query->num_rows == 0)
            {
                return false;
            }
            $result = $query->result();
            return $result[0];
        }
        
        public function getRecordsWhichNeedsToBePromotedFromLevel1($month, $year)
        {
            $result = $this->db->query('Select * from 
                                (SELECT count(*) as count, introducer_id as id
                                FROM customer_info 
                                WHERE month(doj) = '.$month.' 
                                and year(doj) = '.$year.'
                                and introducer_id > 0 
                                group by introducer_id order by introducer_id) table3 
                                where count >= '.$this::min_number);
            return $result;
        }   
        
        public function getFirst9Records($month, $year, $introducer_id)
        {
            $result = $this->db->query('Select id, joining_fee as amount, introducer_id 
                                        from customer_info 
                                        where month(doj) = '.$month.'  
                                        AND year(doj) = '.$year.'
                                        AND introducer_id = '.$introducer_id.' 
                                        order by id 
                                        limit '.$this::min_number);
            return $result;
        }    
    }
    
?>