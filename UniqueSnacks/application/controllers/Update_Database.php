<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_Database extends CI_Controller {
    
    const COMPANY_ID = '1';
    const minDirectCount = 9;
    const maxLevel = 5;
    
    public function __construct()
    {
        parent::__construct();    
    }
    
    
    public function update()
    {
        $month = $_POST['month'];
        $year = $_POST['year'];
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date_param($month, $year);
        
                
        $nextMonth = clone $currentMonth;     
        $nextMonth->getNextMonth();
        
        if($tableModel->isTablePresent('salary_'.$currentMonth))
        {
             $this->load->view('mainpage/header');
             $this->load->view('new/error_message', array(
                        'message'=> 'Cannot Perform Operation as Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.' 
                        has already been generated.<br>Contact Admin' 
                                                        ));
             $this->load->view('mainpage/footer');             
             return;
        }
        
        //creating table for this month salary calculation.
        $tableModel->createTableForSalary('salary_'.$currentMonth); 
        
        //creating table for the next month chaining which includes promotion for this month as well.
        //$tableModel->createTableForChaining('chaining_'.$nextMonth.'_bk');
        
        //if its for the first time.
        if(!$tableModel->isTablePresent('chaining_'.$currentMonth.'_bk'))
        {
            $tableModel->createTableForChaining('chaining_'.$currentMonth);    
        }
        else{
            $tableModel->cloneTable('chaining_'.$currentMonth.'_bk', 'chaining_'.$currentMonth);
        }
        
        $this->load->model('New_record_entry');
        $monthEntries = $this->New_record_entry->getMonthlyData($month, $year);
        
        $this->load->model('Chain_Model');
        $chainModel = new Chain_Model();
        
        $this->load->model('Salary_Model');
        $salaryModel = new Salary_Model();
        
        $currentMonthChaining = 'chaining_'.$currentMonth;
        $nextMonthChaining = 'chaining_'.$nextMonth.'_bk';
        $currentMonthSalary = 'salary_'.$currentMonth;
        
        //inserting the new records in the present month table.        
        foreach($monthEntries->result() as $monthEntry)
        {
            $chainModel->id = $monthEntry->id;
            $chainModel->introducer_id = $monthEntry->introducer_id;
            $chainModel->level_id = 1;
            $chainModel->insert($currentMonthChaining, $chainModel);
        }
        
        
        $calculated_ids = array();
        $newly_incremented = array();
        
        //getting records which needs 1st level promotion
        $level1Records = $chainModel->getRecordsWhichNeedsToBePromotedFromLevel1($month, $year);
        foreach($level1Records->result() as $level1Record)
        {
            $newly_incremented[] = $level1Record->id;
            $mainRecord = $chainModel->getLevel($currentMonthChaining, $level1Record->id);
            
            //distribute salary for 9 people attached to the record.
            $records = $chainModel->getFirst9Records($month, $year, $mainRecord->id);
            foreach ($records->result() as $record) 
            {
                $this->calculateSalary($record, $currentMonthChaining, $currentMonthSalary);
                $calculated_ids[] = $record->id;
            }
            
            //update the level.
            $mainRecord->level_id++;
            
            //update chain.
            while(true)
            {
                $introducer_id = $mainRecord->introducer_id;
                if($introducer_id == $this::COMPANY_ID)
                {
                    break;
                }
                $parent = $chainModel->getLevel($currentMonthChaining, $introducer_id);
                if($parent->level_id >= $mainRecord->level_id)
                {
                    break;
                }
                else{
                    $mainRecord->introducer_id = $parent->introducer_id;
                }
            }
            //update the database
            $chainModel->updateTable($currentMonthChaining, $mainRecord);
        }

        $monthEntries = $chainModel->getMonthlyChainedData($currentMonthChaining ,$month, $year);
        //calculating salary.
        foreach($monthEntries->result() as $monthEntry)
        {
            if(!in_array($monthEntry->id, $calculated_ids))
            {
                $this->calculateSalary($monthEntry, $currentMonthChaining, $currentMonthSalary);
            }
        }        
                
        //giving promotions for the next month.
                $count_persons = array();
                $chained_results = $chainModel->getMonthlyChainedData($currentMonthChaining, $month, $year);
                
                foreach ($chained_results->result() as $chained_result) 
                {
                    $introducer_id = $chained_result->introducer_id;
                    while(true)
                    {
                        if($introducer_id == $this::COMPANY_ID)
                        {
                            break;
                        }
                        else 
                        {
                            if(array_key_exists($introducer_id, $count_persons))
                            {
                                $count_persons[$introducer_id]++;    
                            }
                            else 
                            {
                                $count_persons[$introducer_id] = 1;
                            }    
                            $parent = $chainModel->getLevel($currentMonthChaining, $introducer_id);
                            $introducer_id = $parent->introducer_id;
                        }
                    }            
                }
                
                $tableModel->cloneTable($currentMonthChaining, $nextMonthChaining);
                
                
                foreach ($count_persons as $key => $value) 
                {
                    $row = $chainModel->getLevel($currentMonthChaining, $key);
                    if($row->level_id > 1)
                    {
                        if(in_array($row->id, $newly_incremented))
                        {
                            $value -= $this::minDirectCount;
                        }
                        for($i = $this::maxLevel -1; $i >= $row->level_id; $i--)
                        {
                            if(pow($this::minDirectCount, $i) <= $value)
                            {
                                $row->level_id = $i + 1;
                                break;
                            }
                        }
                    }
                    
                    $chainModel->updateTable($nextMonthChaining, $row);       
                }
                
                $this->load->view('mainpage/header');   
                $this->load->view('new/error_message', array(
                                            'message' => 'Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.
                                                           ' Successfully Updated' 
                                                        ));        
                $this->load->view('mainpage/footer'); 
    }
    
    private function calculateSalary($record, $currentMonthChaining, $currentMonthSalary)
    {
                $salaryModel = new Salary_Model();
                $chainModel = new Chain_Model();
                 
                $amount = $record->amount;
                
                $amount_deducted = 0;
                $introducer_id = $record->introducer_id;
                while($introducer_id != $this::COMPANY_ID)
                {
                    $parent = $chainModel->getIncentive($currentMonthChaining, $introducer_id);
                    $incentive = $parent->share;
                    $incentive -= $amount_deducted;
                    
                    $calculatedAmount = ($incentive * $amount)/100;
                    if($calculatedAmount != 0)
                    {
                        $salaryModel->id = $parent->id;
                        $salaryModel->incentive = $calculatedAmount;
                        $salaryModel->save($currentMonthSalary);
                    }
                    
                    $amount_deducted = $parent->share;
                    $introducer_id = $parent->introducer_id;
                }
    }

    public function revert_all_preceeding_months()
    {
        $date = $_POST['month'];
        $year = $_POST['year'];
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date_param($date, $year);
        
        if(!$tableModel->isTablePresent('salary_'.$currentMonth))
        {
             $this->load->view('mainpage/header');
             $this->load->view('new/error_message', array(
                        'message'=> 'Cannot Perform Operation as Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.' 
                                    has not been generated yet.'
                                                        ));
             $this->load->view('mainpage/footer');             
             return;
        }
      
        $nextMonth = clone $currentMonth;
        $nextMonth->getNextMonth();
        while(true)
        {
            if($tableModel->isTablePresent('salary_'.$currentMonth))
            {
                $tableModel->dropTable('salary_'.$currentMonth);
            
                $tableModel->dropTable('chaining_'.$currentMonth);
                $tableModel->dropTable('chaining_'.$nextMonth.'_bk');
            }
            else{
                break;
            }
            $currentMonth->getNextMonth();
            $nextMonth->getNextMonth();     
        }
        
        $this->load->view('mainpage/header');   
        $this->load->view('new/error_message', array(
                                            'message' => 'Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.
                                                           ' Successfully Reverted Back.' 
                                                        ));        
       $this->load->view('mainpage/footer'); 
        
    }    

    public function revert()
    {
        $date = $_POST['month'];
        $year = $_POST['year'];
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date_param($date, $year);
        
        if(!$tableModel->isTablePresent('salary_'.$currentMonth))
        {
             $this->load->view('mainpage/header');
             $this->load->view('new/error_message', array(
                        'message'=> 'Cannot Perform Operation as Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.' 
                                    has not been generated yet.'
                                                        ));
             $this->load->view('mainpage/footer');             
             return;
        }
      
        $nextMonth = clone $currentMonth;
        $nextMonth->getNextMonth();

        $tableModel->dropTable('salary_'.$currentMonth);
            
        $tableModel->dropTable('chaining_'.$currentMonth);
        $tableModel->dropTable('chaining_'.$nextMonth.'_bk');
        
        $this->load->view('mainpage/header');   
        $this->load->view('new/error_message', array(
                                            'message' => 'Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.
                                                           ' Successfully Reverted Back.' 
                                                        ));        
       $this->load->view('mainpage/footer'); 
        
    }    
}