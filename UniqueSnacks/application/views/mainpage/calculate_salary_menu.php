<script type="text/javascript">
function validate()
{
       if(  document.input.year.value == "" ||
           isNaN( document.input.year.value ) ||
           document.input.year.value.length != 4 )
           {
             alert( "Please provide valid year." );
             document.input.year.focus() ;
             return false;
           }
    return true;
}
</script>
               <div id="nav-bar">
              <div id="nav-bar-style">
                <a href= "#calculate">CALCULATE SALARY AND PROMOTIONS  </a>
                </div>
                <div id="calculate" class="modalDialog">
                    <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input" action="/UniqueSnacks/index.php/Update_Database/update" method="post" onsubmit="return(validate());">
                            Enter the month 
                            <select name="month">
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">Mar</option>
                                <option value="4">Apr</option>
                                <option value="5">May</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                                <option value="8">Aug</option>
                                <option value="9">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select><br>
                            Enter Year <input type="input" name="year">
                            <input type="submit" value="Submit"> 
                            </form>
                        </h4>
                    </div>
                  </div>
                <br>
                <div id="nav-bar-style">
                   <a href= "#revert_database"> REVERT BACK MONTHLY DATA  </a>
                   </div>
                <div id="revert_database" class="modalDialog">
                    <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input1" action="/UniqueSnacks/index.php/Update_Database/revert" method="post">
                            Enter the month 
                            <select name="month">
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">Mar</option>
                                <option value="4">Apr</option>
                                <option value="5">May</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                                <option value="8">Aug</option>
                                <option value="9">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select><br>
                            Enter Year <input type="input" name="year">
                            <input type="submit" value="Submit"> 
                            </form>
                        </h4>
                    </div>
                </div> 
      
          <br>
                <div id="nav-bar-style">
                   <a href= "#revert_database1"> REVERT BACK PRECEEDING MONTHS DATA  </a>
                   </div>
                <div id="revert_database1" class="modalDialog">
                    <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input1" action="/UniqueSnacks/index.php/Update_Database/revert_all_preceeding_months" method="post">
                            Enter the month 
                            <select name="month">
                                <option value="1">Jan</option>
                                <option value="2">Feb</option>
                                <option value="3">Mar</option>
                                <option value="4">Apr</option>
                                <option value="5">May</option>
                                <option value="6">Jun</option>
                                <option value="7">Jul</option>
                                <option value="8">Aug</option>
                                <option value="9">Sep</option>
                                <option value="10">Oct</option>
                                <option value="11">Nov</option>
                                <option value="12">Dec</option>
                            </select><br>
                            Enter Year <input type="input" name="year">
                            <input type="submit" value="Submit"> 
                            </form>
                        </h4>
                    </div>
                </div> 
            </div>        
      
           