<style>
                #header {
                            background-color:black;
                            color:white;
                            text-align:center;
                            padding:5px;
                        }
                #nav {
                            line-height:30px;
                            background-color:#eeeeee;
                            height:1000px;
                            width:250px;
                            float:left;
                            padding:5px;          
                        }
                #navbar{

                }
                #section {
                            width:350px;
                            float:left;
                            padding:10px;        
                        }
            .modalDialog {
                            position: fixed;
                            font-family: Arial, Helvetica, sans-serif;
                            top: 0;
                            right: 0;
                            bottom: 0;
                            left: 0;
                            background: rgba(0,0,0,0.8);
                            z-index: 99999;
                            opacity:0;
                            -webkit-transition: opacity 0ms ease-in;
                            -moz-transition: opacity 0ms ease-in;
                            transition: opacity 0ms ease-in;
                            pointer-events: none;
                        }

            .modalDialog:target {
                            opacity:1;
                            pointer-events: auto;
                                }

            .modalDialog > div {
                            width: 400px;
                            position: relative;
                            margin: 10% auto;
                            padding: 5px 20px 13px 20px;
                            border-radius: 10px;
                            background: #fff;
                            background: -moz-linear-gradient(#fff, #999);
                            background: -webkit-linear-gradient(#fff, #999);
                            background: -o-linear-gradient(#fff, #999);
                                }

            .close {
                            background: #606061;
                            color: #FFFFFF;
                            line-height: 25px;
                            position: absolute;
                            right: -12px;
                            text-align: center;
                            top: -10px;
                            width: 24px;
                            text-decoration: none;
                            font-weight: bold;
                            -webkit-border-radius: 12px;
                            -moz-border-radius: 12px;
                            border-radius: 12px;
                            -moz-box-shadow: 1px 1px 3px #000;
                            -webkit-box-shadow: 1px 1px 3px #000;
                            box-shadow: 1px 1px 3px #000;
                   }

            .close:hover { background: #ffffff; }
</style>
  <script>  
  function OpenWindow(){  
    for(i=0;i<document.FormName["sal_cal"].length;i++){  
      if(document.FormName["sal_cal"][i].checked){  
    window.open(document.FormName["sal_cal"][i].value,"_self");  
    break;  
  }  
}  
  }  
</script> 
<html>
    <head>
        <title> UniqueSnacks </title>
    </head>

<body>
    <div id="header">
        <h1 > <center> <u> UNIQUE SNACKS SALARY MANAGEMENT SYSTEM </u>  </center> </h1>
    </div>
    <div id="nav">
        <div class="navbar">
        <ul>
            <li> 
            <a href= "/UniqueSnacks/index.php/mainpage/customer_info_menu" > CUSTOMER INFO </a> 
            </li> 
            <li> 
            <a href= "/UniqueSnacks/index.php/mainpage/display_monthly_menu" > DISPLAY </a> 
            </li> 
            <li> 
            <a href= "/UniqueSnacks/index.php/mainpage/calculate_salary_menu" > CALCULATE SALARY </a> 
            </li> 
                     
        </ul>
        </div>
    </div>  
    <div id="section">