<?php
    class Chain_Model extends CI_Model
    {   
        public $id, $level_id, $chain;
        function __construct()
        {
            parent::__construct();
        }   
        
        public function insert_multiple_rows($tableName, $rows)
        {
            var_dump($rows);
            foreach ($rows->result() as $row) {
                                
                if($row->introducer_id == '0')
                {
                    $chain = '0';
                }
                else 
                {
                    $introducer_chain = $this->getChain($tableName, $row->introducer_id);
                    $chain = $row->introducer_id.'-'.$introducer_chain;
                }
                $this->db->insert($tableName, array('id'=>$row->id, 'chain'=>$chain, 'level_id'=>'1'));
            }
        }
        
        public function getChain($tableName,$id)
        {
            $query = $this->db->get_where($tableName, array(
                'id'=>$id
                ));
                
            if($query->num_rows == 1)
            {
               $result = $query->result();
               return $result[0]->chain; 
            }         
        }
        
        public function getIncentive($table, $id)
        {
            $result = $this->db->query('Select level.percentage_share as share 
                              from level 
                              JOIN '.$table.' as table2
                              ON level.level_id=table2.level_id 
                              where table2.id = '.$id);
            $rows = $result->result();
            return $rows[0]->share;
        }
        
        public function getIDSet($table)
        {
            $result  = $this->db->query('Select * from '.$table);
            return $result;
        }
        
        public function getRowsPerPersonPerMonth($table, $id, $month, $year)
        {
            $result = $this->db->query('SELECT table1.chain as chain, table1.id as id, table2.joining_fee as amount 
                                        FROM '.$table.' as table1
                                        JOIN customer_info as table2
                                        ON table1.id = table2.id
                                        where month(table2.doj) in('.$month.') and year(table2.doj) in('.$year.') 
                                        AND table1.chain like \''.$id.'-%\' OR table1.chain like \'%-'.$id.'-%\'' );
            return $result;
            
        }
        
        public function countDirectPersonsAddedPerMonth($table, $id, $month, $year)
        {
            $result = $this->db->query('select count(*) as count from 
                              (SELECT table1.chain, table2.id
                              FROM '.$table.' as table1
                              JOIN customer_info as table2
                              ON table1.id=table2.id 
                              where month(table2.doj) in('.$month.') and year(table2.doj) in('.$year.')) table3
                              where table3.chain like \''.$id.'-%\' ');
             $rows = $result->result();
             return $rows[0]->count;  
        }
        
        public function countIndirectPersonsAddedPerMonth($table, $id, $month, $year)
        {
            $result = $this->db->query('select count(*) as count from 
                              (SELECT table1.chain, table2.id
                              FROM '.$table.' as table1
                              JOIN customer_info as table2
                              ON table1.id=table2.id 
                              where month(table2.doj) in('.$month.') and year(table2.doj) in('.$year.')) table3
                              where table3.chain like \'%-'.$id.'-%\'');
            $rows  = $result->result();
            return $rows[0]->count;
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
    }
    
?>