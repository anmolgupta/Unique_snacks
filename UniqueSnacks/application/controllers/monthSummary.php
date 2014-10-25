<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MonthSummary extends CI_Controller {
    
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
        
        if(!$tableModel->isTablePresent(''.$currentMonth.'_salary'))
        {
             $this->load->view('new/error_message', array(
                        'message'=> 'Cannot calculated as data NOT generated<br>Contact Admin' 
                                                        ));
                return;
        }
        
        $this->load->model('Salary_Model');
        $salaryModel = new Salary_Model();
        
        $result = $salaryModel->getTableRecordsWithAccountDetails(''.$currentMonth.'_salary');
        $this->load->view('salary_display/total_month_summary', array(
                                                                'month'=>$month, 
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
        
        if(!$tableModel->isTablePresent(''.$currentMonth.'_salary'))
        {
             $this->load->view('new/error_message', array(
                                                    'message'=> 'Cannot calculated as data NOT generated<br>Contact Admin' 
                                                        ));
                return;
        }
        
        $result = $chainModel->getLevel(''.$currentMonth.'_chaining', $id);
        if(!$result)
        {
            $this->load->view('new/error_message', array(
                                                    'message'=> 'ID not present.' 
                                                        ));
                return;    
        }
        
        
        if($result->level_id != 2)
        {
            $this->calculateSalaryIfLevelIdNotManipulated($chainModel, $currentMonth, $id, $month, $year);
        }
        else
        {
            //finding the level_id of the previous month & if the row has been added in this month.
            $previousMonth = clone $currentMonth;
            $previousMonth->getPreviousMonth();
            
            //if table present
            if($tableModel->isTablePresent(''.$previousMonth.'_salary'))
            {
                $previousMonthTableRecord = $chainModel->getLevel(''.$previousMonth.'_salary', $id);
                
                if($previousMonthTableRecord == false)
                {
                    $this->calculateSalaryIfLevelIdManipulated($chainModel, $currentMonth, $id, $month, $year);
                }
                else if($previousMonthTableRecord->level_id == 2)
                {
                    $this->calculateSalaryIfLevelIdNotManipulated($chainModel, $currentMonth, $id, $month, $year);
                }
                
            }
            else
            {
               $this->calculateSalaryIfLevelIdManipulated($chainModel, $currentMonth, $id, $month, $year);
                
            }
        }
     }
    private function calculateSalaryIfLevelIdManipulated($chainModel, $currentMonth,  $id, $month, $year)
    {
        $result = $chainModel->countDirectPersonsAddedPerMonth(''.$currentMonth.'_chaining', $id, $month, $year);
        $level_id =1;
        
        $incentive = $this->Table_Model->getIncentiveFromLevelTable($level_id);
        $tableView = array();
        $i = 0;
        foreach($result->result() as $row)
        {
              $i++;
              
              $amount = ($row->amount * $incentive)/100;
              $tableView[] = array(
                                    'id' => $row->id ,
                                    'amount' => $amount);
              
              if($i == 9)
              {
                  $level_id++;
                  $incentive = $this->Table_Model->getIncentiveFromLevelTable($level_id);
              }  
        }
        
        $result = $chainModel->countIndirectPersonsAddedPerMonth(''.$currentMonth.'_chaining', $id, $month, $year);
        foreach($result->result() as $row)
        {
            $amount = $row->amount;
            
            $chain_array = explode('-',$row->chain);
            
            $amount_deducted = 0;
                        
            foreach($chain_array as $chain)
            {
                    if($chain == $id)
                    {
                        $incentive =  $chainModel->getIncentive(''.$currentMonth.'_chaining', $id);
                        $incentive -=  $amount_deducted;
                        $calculatedAmount = ($amount * $incentive)/100; 
                        $tableView[] = array(
                            'id' => $row->id,
                            'amount' => $calculatedAmount,
                              ); 
                        break;    
                    }
                    $amount_deducted = $chainModel->getIncentive(''.$currentMonth.'_chaining', $chain);
            }                        
        }
         $ret_value = array(
                     'id'=>$id,
                     'month'=>$month,
                     'year'=>$year,
                     'tableView'=>$tableView      
                           );

        $this->load->view('salary_display/per_person_month_summary',$ret_value);
    }   
    
     
    //this work needs to be done if the person is not promoted from level1     
    private function calculateSalaryIfLevelIdNotManipulated($chainModel, $currentMonth,  $id, $month, $year)
    {
        $result = $chainModel->getRowsPerPersonPerMonth(''.$currentMonth.'_chaining', $id, $month, $year);
        
        $tableView = array();
        
        foreach($result->result() as $row)
        {
            $amount = $row->amount;
            
            $chain_array = explode('-',$row->chain);
            
            $amount_deducted = 0;
                        
            foreach($chain_array as $chain)
            {
                    //var_dump($chain);
                    if($chain == $id)
                    {
                        $incentive =  $chainModel->getIncentive(''.$currentMonth.'_chaining', $id);
                        $incentive -=  $amount_deducted;
                        $calculatedAmount = ($amount * $incentive)/100; 
                        $tableView[] = array(
                            'id' => $row->id,
                            'amount' => $calculatedAmount,
                              ); 
                        break;    
                    }
                    $amount_deducted = $chainModel->getIncentive(''.$currentMonth.'_chaining', $chain);
            }                        
        }
        
        $ret_value = array(
                     'id'=>$id,
                     'month'=>$month,
                     'year'=>$year,
                     'tableView'=>$tableView      
                           );

        $this->load->view('salary_display/per_person_month_summary',$ret_value);
    }
}
