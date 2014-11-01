               <div id="nav-bar">
               <div id="nav-bar-style">
               <a href= "#month_sal"> MONTHLY SUMMARY  </a><br>
               </div>
               <br>
               <div id="nav-bar-style"> 
               <a href= "#individual_id"> INDIVIDUAL SUMMARY  </a><br><br>
                </div>
                <div id="month_sal" class="modalDialog">
                     <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input" action="/UniqueSnacks/index.php/monthSummary/total_month_summary" method="post">
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
               <div id="individual_id" class="modalDialog">
                    <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input" action="/UniqueSnacks/index.php/monthSummary/per_person_month_summary" method="post"> 
                                ID OF EMPLOYEE <input type="text" name="id"><br>
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
            