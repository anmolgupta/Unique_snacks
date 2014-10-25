<?php 

    class MY_Model extends CI_Model
    {
        const DB_TABLE = 'abstract_table';
        const DB_TABLE_PK = 'abstract_primary_key';
        
        function __construct()
        {
        	parent::__construct();	
        }
        
        private function insert()
        {
            $this->db->insert($this::DB_TABLE, $this);
            $this->{$this::DB_TABLE_PK} = $this->db->insert_id();
        }
        
        private function update()
        {
            $this->db->update($this::DB_TABLE, $this, $this::DB_TABLE_PK);
            
        }
      
        public function populate($row)
        {
            foreach ($row as $key => $value) {
                $this->$key = $value;
            }
        }
        
        public function load($id)
        {
            $query = $this->db->get_where(this::DB_TABLE, array($this::DB_TABLE_PK => $id));
            $this->populate($query->row());
        }
        
        public function delete()
        {
            $this->db->delete($this::DB_TABLE, array($this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}));
            unset($this->{$this::DB_TABLE_PK});
        }
        
        public function save()
        {
            if(isset($this->{$this::DB_TABLE_PK}))
            {
                $this->update();
            }
            else{
                $this->insert();
            }
        }
       
    }
