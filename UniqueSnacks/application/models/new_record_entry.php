<?php
    class New_record_entry extends MY_Model
    {
        const DB_TABLE = 'customer_info';
        const DB_TABLE_PK = 'id';
          
        public $doj, $name, $id, $husband_fathername, $sex, $dob, $place_of_birth, $marital_status;
        public $nationality, $pan_no, $address, $city, $pincode, $phone_no;
        public $mobile_no, $nominee_name, $relationship_with_nominee, $joining_fee;
        public $introducer_id, $account_no, $name_of_bank, $name_of_branch; 

        
        function __construct()
        {
            parent::__construct();
        }
        
        public function getMonthlyData($month, $year)
        {
            $result = $this->db->query('Select id, introducer_id, joining_fee as amount
                                        from '.$this::DB_TABLE.' 
                                        where month(doj) IN ( '.$month.' ) 
                                        AND year(doj) In ( '.$year.' ) 
                                        order by id');
            return $result;
        }
        
        public function update()
        {
            $this->db->where($this::DB_TABLE_PK, $this->id);
            $this->db->update($this::DB_TABLE, $this);
            
        }
        public function getRecordRelatedToIntroducer($introducer_id)
        {
            $result = $this->db->query('Select * from '.$this::DB_TABLE.' where introducer_id = '.$introducer_id);
            return $result->num_rows;
        }
        
        public function getRecord($introducer_id)
        {
            
            $query  = $this->db->query('Select * from '.$this::DB_TABLE.' where '.$this::DB_TABLE_PK.' = '.$introducer_id);
            
            if($query->num_rows == 0)
            {
                return false;
            }
            $result = $query->result();
            return $result[0];
        }
        
        public function delete_record($id)
        {
            $this->db->query('DELETE FROM '.$this::DB_TABLE.' where '.$this::DB_TABLE_PK.' = '.$id);
        }
    }
