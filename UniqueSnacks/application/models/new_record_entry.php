<?php
    class New_record_entry extends MY_Model
    {
        const DB_TABLE = 'customer_info';
        const DB_TABLE_PK = 'id';
          
        public $doj, $name, $id, $husband_fathername, $sex, $dob, $place_of_birth, $marital_status;
        public $nationality, $pan_no, $address, $city, $pincode, $phone_no;
        public $mobile_no, $nominee_name, $relationship_with_nominee, $joining_fee, $introducer_name;
        public $introducer_id, $account_no, $name_of_bank, $name_of_branch; 

        
        function __construct()
        {
            parent::__construct();
        }
        
        public function getMonthlyData($month, $year)
        {
            $result = $this->db->query('Select id, introducer_id 
                                        from '.$this::DB_TABLE.' 
                                        where month(doj) IN ( '.$month.' ) 
                                        AND year(doj) In ( '.$year.' ) 
                                        order by id');
            return $result;
        }
        
        
        public function ifIntroducerPresent($introducer_id, $introducer_name)
        {
            
            $query  = $this->db->query('Select * from '.$this::DB_TABLE.' where '.$this::DB_TABLE_PK.' = '.$introducer_id.' and name like \''.$introducer_name.'\'');
            
            if($query->num_rows == 0)
            {
                return false;
            }
            return true;
        }
    }
