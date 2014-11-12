<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MonthSummary extends CI_Controller {
    
    const COMPANY_ID = '1';   
    public function __construct()
    {
        parent::__construct();    
    }
    
    
    public function total_month_summary()
    {
        $month = $_POST['month'];
        $year = $_POST['year'];
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date_param($month, $year);
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        if(!$tableModel->isTablePresent('salary_'.$currentMonth))
        {
             $this->load->view('mainpage/header');
             $this->load->view('new/error_message', array(
                        'message'=> 'Cannot Perform Operation as Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.' 
                        is not present.<br>Contact Admin' 
                                                        ));
                return;
             $this->load->view('mainpage/footer');
        }
        
        $this->load->model('Salary_Model');
        $salaryModel = new Salary_Model();
        
        $result = $salaryModel->getTableRecordsWithAccountDetails('salary_'.$currentMonth);
        $this->load->view('salary_display/total_month_summary', array(
                                                                'month'=>$currentMonth->getCurrentMonth(), 
                                                                 'year'=>$year,
                                                                 'rows'=>$result->result_array()
                                                                 ));
        
        
    }
    
    public function per_person_month_summary()
    {
        $month = $_POST['month'];
        $year = $_POST['year'];
        $id = $_POST['id'];
            
        $this->load->model('Chain_Model');
        $chainModel = new Chain_Model();    
        
        $this->load->library('Date_Model');
        $currentMonth = new Date_Model();
        $currentMonth->set_date_param($month, $year);
        
        
        $this->load->model('Table_Model');
        $tableModel = new Table_Model();
        
        if(!$tableModel->isTablePresent('chaining_'.$currentMonth))
        {
            $this->load->view('mainpage/header');
            $this->load->view('new/error_message', array(
                                          'message'=> 'Cannot Perform Operation as Data for '.$currentMonth->getCurrentMonth().', '.$currentMonth->year.' 
                        is not present.<br>Contact Admin'  
                                                        ));
            $this->load->view('mainpage/footer');
            return;
        }
        
        $currentMonthChaining = 'chaining_'.$currentMonth;
        
        //getting records which are on level2.
        $result = $chainModel->getRecordsHavingLevel2($currentMonthChaining);
        
        //getting the records which are upgraded from level1 to level 2 in current month.
        $upgraded_records = $this->getUpgradedRecords($currentMonth, $result);
        
        $this->load->model('New_record_entry');
        
        $view_elements = array();
        $calculated_ids = array();
        
        $min_level = $tableModel->getPercentageShare(1);
        //traversing the records which are updated in the current month        
        foreach ($upgraded_records as $upgraded_record) 
        {
            $records = $chainModel->getFirst9Records($month, $year, $upgraded_record);
            foreach($records->result() as $record)
            {
                $amount = $record->amount;
                
                $amount_deducted = 0;
                $introducer_id = $record->introducer_id;
                
                $chain_element = 0;
                while($introducer_id != $this::COMPANY_ID)
                {
                    if($chain_element == 0)
                    {
                        $parent = $chainModel->getIncentive($currentMonthChaining, $introducer_id);
                        $parent->share =$min_level;
                        $incentive = $parent->share;
                        $incentive -= $amount_deducted;
                    }
                    else
                    {
                        $parent = $chainModel->getIncentive($currentMonthChaining, $introducer_id);
                        $incentive = $parent->share;
                        $incentive -= $amount_deducted;
                    }
                    
                    
                    $calculatedAmount = ($incentive * $amount)/100;
                    if($parent->id == $id)
                    {
                        $view_elements[] = array(
                                            'id' => $record->id,
                                            'amount' => $calculatedAmount
                                                );
                    }
                    
                    $amount_deducted = $parent->share;
                    $introducer_id = $parent->introducer_id;
                    $chain_element++;
                }
                $calculated_ids[] = $record->id;
            }
        }
        
        //calculating salary.
        $monthEntries = $chainModel->getMonthlyChainedData($currentMonthChaining ,$month, $year);
        foreach($monthEntries->result() as $monthEntry)
        {
            if(!in_array($monthEntry->id, $calculated_ids))
            {
                $amount = $monthEntry->amount;
                
                $amount_deducted = 0;
                $introducer_id = $monthEntry->introducer_id;
                while($introducer_id != $this::COMPANY_ID)
                {
                    $parent = $chainModel->getIncentive($currentMonthChaining, $introducer_id);
                    $incentive = $parent->share;
                    $incentive -= $amount_deducted;
                    
                    $calculatedAmount = ($incentive * $amount)/100;
                    if($parent->id == $id)
                    {
                        $view_elements[] = array(
                                            'id' => $monthEntry->id,
                                            'amount'=> $calculatedAmount    
                                                );
                    }
                    
                    $amount_deducted = $parent->share;
                    $introducer_id = $parent->introducer_id;
                }
            }
        }

        $record = $this->New_record_entry->getRecord($id);
        $this->load->view('salary_display/per_person_month_summary', array(
                                                                      'tableView' => $view_elements,
                                                                      'id' => $id,
                                                                      'month' => $currentMonth->getCurrentMonth(),
                                                                      'year' => $year,
                                                                      'name' => $record->name
                                                                          ));

           
     }

    private function getUpgradedRecords($currentMonth, $result)
    {
        $previousMonth = clone $currentMonth;
        $previousMonth->getPreviousMonth();
        
        $previousMonthChaining =  'chaining_'.$previousMonth;
        $tableModel = new Table_Model();
        
        $ret_array = array();
        
        if($tableModel->isTablePresent($previousMonthChaining))
        {
            foreach($result->result() as $row)
            {
                $chainModel = new Chain_Model();
                $previousMonthRow = $chainModel->getLevel($previousMonthChaining, $row->id);
                if($previousMonthRow == false)
                {
                    $ret_array[] = $row->id; 
                }
                else{
                    if($previousMonthRow->level_id == 1)
                    {
                        $ret_array[] = $row->id;
                    }
                }
            }
        }
        else 
        {
            foreach($result->result() as $row)
            {
                $ret_array[] = $row->id;    
            }    
        }
        return $ret_array;
    }
}
