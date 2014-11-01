        <div id="nav-bar">
            <div id="nav-bar-style">
            <a href= "/UniqueSnacks/index.php/newEntry/login" > NEW RECORD </a> 
            </div>
            <br>
                <div id="nav-bar-style">
                              <a href= "#search_record"> SEARCH RECORD </a> 
                <div id="search_record" class="modalDialog">
                     <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input" action="/UniqueSnacks/index.php/newEntry/search" method="post">ID OF EMPLOYEE <input type="text" name="user">
                                                                                     <input type="submit" value="Submit">
                            </form>
                        </h4>
                    </div>
                </div>
            </div>
           <br>

           <div id="nav-bar-style"> 
            <a href= "#update_record"> UPDATE RECORD </a>
                <div id="update_record" class="modalDialog">
                    <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input" action="/UniqueSnacks/index.php/newEntry/update" method="post"> ID OF EMPLOYEE <input type="text" name="user">
                                                                                     <input type="submit" value="Submit">
                            </form>
                        </h4>
                    </div>
                </div>
            </div>
            <br>
            <div id="nav-bar-style">
            <a href= "#delete_record"> DELETE RECORD </a>
                <div id="delete_record" class="modalDialog">
                    <div> <a href="#close" title="Close" class="close">X</a>
                        <h4> 
                            <form name="input" action="/UniqueSnacks/index.php/newEntry/delete" method="post"> ID OF EMPLOYEE <input type="text" name="user">
                                                                                     <input type="submit" value="Submit">
                            </form>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
             