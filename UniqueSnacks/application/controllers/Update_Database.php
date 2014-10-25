<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_Database extends CI_Controller {
    
    
    const minDirectCount = 9;
    const maxLevel = 5;
    const JOINING_FEE = 1000; //to be changed definitely.
    
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
        
                
        $nextMonth = clone $currentMonth;     
        $nextMonth->getNextMonth();
        
        if($tableModel->isTablePresent(''.$nextMonth.'_chaining'))
        {
             $this->load->view('new/error_message', array(
                        'message'=> 'data already generated<br>Contact Admin' 
                                                        ));
                return;
        }
        
        //creating table for this month salary calculation.
        $tableModel->createTableForSalary(''.$currentMonth.'_salary'); 
        
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
        
        $this->load->model('Salary_Model');
        $salaryModel = new Salary_Model();
        
        //inserting the new records in the present month table.
        echo 'Inserting the records <br>';
        $chainModel->insert_multiple_rows(''.$currentMonth.'_chaining', $rows); 
        
        $calculated_records = array();
        
        //giving promotions
        
        //getting the whole chain Model for current Model.
        $result = $chainModel->getIDSet(''.$currentMonth.'_chaining');
        
        foreach($result->result() as $row)
        { 
            if($row->level_id == '1')
            {
                //getting records which are directly connected to the row.
                $num_rows = $chainModel->countDirectPersonsAddedPerMonth(''.$currentMonth.'_chaining', $row->id, $date, $year);
                $directPersonsAdded = $num_rows->num_rows;
                
                if($directPersonsAdded >= $this::minDirectCount)
                {
                    //get the incentive for 9 people.
                    $incentive = $tableModel->getIncentiveFromLevelTable($row->level_id);
                    $amount = ($this::minDirectCount * $this::JOINING_FEE * $incentive)/100;
                    
                    $row->level_id++;
                    
                    //saving the chain of row before any change.
                    $recordChain = $row->chain;
                    
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
                            $parent = $chainModel->getLevel(''.$currentMonth.'_chaining', $chain);
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
                    
                    //update this table with this record
                    $chainModel->updateTable(''.$currentMonth.'_chaining', $row);
                    
                    //manipulating the chain of the records which are associated to this $row.
                    if(strcmp($row->chain, $recordChain)!==0)
                    {
                        //getting the records which contains $row->id in chain.
                        $relatedRecords = $chainModel->getRelatedRecords(''.$currentMonth.'_chaining', $row->id);
                        
                        //updating the records
                        foreach($relatedRecords->result() as $relatedRecord)
                        {
                            $chain_array = explode('-',$relatedRecord->chain);
                            $chainBuilder = '';
                            foreach($chain_array as $chain)
                            {
                                if($chain == $row->id)
                                {
                                    $chainBuilder .=$row->id.'-'.$row->chain;
                                    $relatedRecord->chain = $chainBuilder;
                                    break;    
                                }
                                else
                                {
                                    $chainBuilder .=$chain.'-';        
                                }
                            }
                            $chainModel->updateTable(''.$currentMonth.'_chaining', $relatedRecord);
                        }
                    }
                    
                    //updating salary table accordingly. 
                    $salaryModel->id = $row->id;
                    $salaryModel->incentive = $amount;
                    $salaryModel->save(''.$currentMonth.'_salary');                
                    
                    
                    //adding this in an array that the record has been traversed as a direct transaction.
                    $calculated_records[$row->id] = 0;
                    
                    //manipulating if another promotion is required
                    $num_rows = $chainModel->countIndirectPersonsAddedPerMonth(''.$currentMonth.'_chaining', $row->id, $date, $year);
                    $indirectPersonsAdded = $num_rows->num_rows;
                    $indirectPersonsAdded += $directPersonsAdded - $this::minDirectCount; 
                    for($i = $this::maxLevel -1; $i >= $row->level_id; $i--)
                    {
                        if(pow($this::minDirectCount, $i) <= $indirectPersonsAdded)
                        {
                            $row->level_id = $i + 1;
                            break;
                        }
                    }
                }                
                   
            }
	        
            //calculating indirect persons and manipulating the level accordingly.
            else if($row->level_id > 1)
            {   
	            $num_rows = $chainModel->countAllPersonsAddedPerMonth(''.$currentMonth.'_chaining', $row->id, $date, $year);
                $indirectPersonsAdded = $num_rows->num_rows;
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
        
        foreach($result->result() as $row)
        {
            
            $amount = $row->amount;
            $chain_array = explode('-',$row->chain);
            
            $amount_deducted = 0;
            $iterator = 0;
                
            foreach($chain_array as $chain)
            {
                $iterator++;
                if($chain !== '0')
                {
                   
                    //var_dump($chain);
                    $incentive = $chainModel->getIncentive(''.$currentMonth.'_chaining', $chain);
                    $calculatedincentive  = $incentive - $amount_deducted; 
                    $salaryModel->id = $chain;
                    $salaryModel->incentive = ($amount * $calculatedincentive)/100;
                    if($salaryModel->incentive != 0)
                    {
                        if($iterator === 1 && array_key_exists($chain, $calculated_records))
                        {
                            if($calculated_records[$chain] < $this::minDirectCount)
                            {
                                $calculated_records[$chain]++;
                            }else{
                                $salaryModel->save(''.$currentMonth.'_salary');  
                            }
                        }
                        else{
                            $salaryModel->save(''.$currentMonth.'_salary');
                        }                
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