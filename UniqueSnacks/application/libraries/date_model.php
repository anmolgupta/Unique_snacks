<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Date_Model
	{
	    private $month_array = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
        public $month;
        public $year;
        
        function __toString()
        {
            return ''.$this->month_array[$this->month].''.$this->year;
        }
        
        function set_date($date)
        {
            $exploded_date = explode('/', $date);
            $this->month = $exploded_date[1];
            $this->year = $exploded_date[0];
        }
        
        function set_date_param($month, $year)
        {
            $this->month = $month;
            $this->year = $year;
        }
        
        function getCurrentMonth()
        {
            return $this->month_array[$this->month];    
        }
        
        function getNextMonth()
        {
           
            if($this->month == 12)
            {
                $this->month = $this->month_array[1];
                $this->year++;
            }
            else 
            {
                $this->month++;
            }
        }
        
        function getPreviousMonth()
        {
       
             if($this->month == 1)
             {
                 $this->month = 12;
                 $this->year--;
             }
             else 
             {
                 $this->month--;
             }
       }	    
	}
?>
