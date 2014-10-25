<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_Database extends CI_Controller {
    
    
    const minDirectCount = 9;
    const maxLevel = 5;
    
    public function __construct()
    {
        parent::__construct();    
    }
    
    
    public function update()
    {
        $date = $_POST['month'];
        $year = $_POST['year'];
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date_param($date, $year);
        
        if($tableModel->isTablePresent(''.$currentMonth.'_salary'))
        {
             $this->load->view('new/error_message', array(
                        'message'=> 'data already generated<br>Contact Admin' 
                                                        ));
                return;
        }
        //creating table for this month salary calculation.
        $tableModel->createTableForSalary(''.$currentMonth.'_salary'); 
        
        $nextMonth = clone $currentMonth;     
        $nextMonth->getNextMonth();
        
        //creating table for the next month chaining which includes promotion for this month as well.
        $tableModel->createTableForChaining(''.$nextMonth.'_chaining');
        
        //if its for the first time.
        if(!$tableModel->isTablePresent(''.$currentMonth.'_chaining'))
        {
            $tableModel->createTableForChaining(''.$currentMonth.'_chaining');    
        }
        
        $this->load->model('New_record_entry');
        $rows = $this->New_record_entry->getMonthlyData($date, $year);
        
        $this->load->model('Chain_Model');
        $chainModel = new Chain_Model();
        
        //inserting the new records in the present month table.
        echo 'Inserting the records <br>';
        $chainModel->insert_multiple_rows(''.$currentMonth.'_chaining', $rows); 
        
        //giving promotions
        $result = $chainModel->getIDSet(''.$currentMonth.'_chaining');
        
        foreach($result->result() as $row)
        {
            
            if($row->level_id == '1')
            {
                $directPersonsAdded = $chainModel->countDirectPersonsAddedPerMonth(''.$currentMonth.'_chaining', $row->id, $date, $year);
                if($directPersonsAdded >= $this::minDirectCount)
                {
                    $row->level_id++;
                }   
            }
	        
            //calculating indirect persons and manipulating the level accordingly.
            if($row->level_id > 1)
            {   
	           $indirectPersonsAdded = $chainModel->countIndirectPersonsAddedPerMonth(''.$currentMonth.'_chaining', $row->id, $date, $year);
                for($i = $this::maxLevel -1; $i >= $row->level_id; $i--)
                {
                    if(pow($this::minDirectCount, $i) <= $indirectPersonsAdded)
                    {
                        $row->level_id = $i + 1;
                        break;
                    }
                }
            }
            
            //manipulating chain if necessary
            $chain_array = explode('-', $row->chain);
            foreach($chain_array as $chain)
            {
                if($chain === '0')
                {
                     $row->chain = '0';  
                }
                else 
                {
                    $parent = $chainModel->getLevel(''.$nextMonth.'_chaining', $chain);
                    if($parent->level_id >= $row->level_id)
                    {
                        $row->chain = $parent->id.'-'.$parent->chain;
                        break;
                    }
                    else 
                    {
                        $row->chain = $parent->chain;
                    }
                }
            }
            
            $chainModel->insert(''.$nextMonth.'_chaining', $row);
        }
        
        //calculating salary
        $result = $tableModel->calculateSalary(''.$currentMonth.'_chaining',$date, $year);
        
        $this->load->model('Salary_Model');
        $salaryModel = new Salary_Model();
        
        foreach($result->result() as $row)
        {
            
            $amount = $row->amount;
            $chain_array = explode('-',$row->chain);
            
            $amount_deducted = 0;
                        
            foreach($chain_array as $chain)
            {
                if($chain !== '0')
                {
                    //var_dump($chain);
                    $incentive = $chainModel->getIncentive(''.$currentMonth.'_chaining', $chain);
                    $calculatedincentive  = $incentive - $amount_deducted; 
                    $salaryModel->id = $chain;
                    $salaryModel->incentive = ($amount * $calculatedincentive)/100;
                    if($salaryModel->incentive != 0)
                    {
                        $salaryModel->save(''.$currentMonth.'_salary');                
                    }
                    $amount_deducted = $incentive;
                }
            }   
        }
    }
    

    public function revert()
    {
        $date = '5';
        $year = '2014';
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date_param($date, $year);
        
        $nextMonth = clone $currentMonth;
        $nextMonth->getNextMonth();
        
        $tableModel->dropTable(''.$currentMonth.'_salary');
        
        $tableModel->dropTable(''.$currentMonth.'_chaining');
        $tableModel->dropTable(''.$nextMonth.'_chaining');
        
    }    
}