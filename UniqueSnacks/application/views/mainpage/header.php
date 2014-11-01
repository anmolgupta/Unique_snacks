<style>
                #header {
                            background-color:black;
                            color:white;
                            text-align:center;
                            width: 100%;
                            height:80px;
                            vertical-align: middle;
                            font-family: Arial, Helvetica, sans-serif;
                            padding-top: 10px;
                        }
                #nav {
                            line-height:40px;
                            background-color:#4092ED;
                            height:1000px;
                            width:200px;
                            float:left;
                            font-family: Arial, Helvetica, sans-serif;
                            padding:5px;          
                        }
                #nav a{
                        color: #000000;


                }
                #nav-bar{
                            background-color:#FFFFFF;
                            height:100%;
                            width:350px;
                            float:left;
                            font-family: Arial, Helvetica, sans-serif;
                            padding:40px;
                            margin-left: 100px;   
                            vertical-align: middle;  
                            line-height: 50px;     
                        }
                #nav-bar a{
                    color: #000000;
                }

                #nav-bar h2{
                    text-align: center;
                    color: #0B0B61;
                }
                #nav-bar-style
                {
                border: 2px solid #a1a1a1;
                padding: 0px 80px; 
                background: #4092ED;
                border-radius: 40px;
                height: 40px;
                text-align: center;
                width: 100%;
                line-height: 40px;
                }

                .boldtable, .boldtable th
                            {
                            border: 1px solid black;
                            font-size:15pt;
                            color:#000000;
                            padding: 3px;
                            font-family: Arial, Helvetica, sans-serif;
                            background-color:#ffffff;
                            height: 100%;
                            width: 100%;
                            }
                .boldtable td
                            {
                               border: 2px solid black;
                            font-family: Arial, Helvetica, sans-serif;
                            font-size:10pt;
                            color:#000000;
                            padding: 10px;
                            text-align: center;
                            background-color:#ffffff;
                            }
                table {
                                width: 100%;
                                border-collapse: collapse;
                       }

                #footer {
                                width: 100%;    
                                height:40px;
                                bottom:0;
                                font-family: Arial, Helvetica, sans-serif;
                                padding: 5px;
                                vertical-align: middle;
                                background-color:black;
                                color:white;
                                clear:both;
                                line-height: 10px;
            }

                /*#section {
                            width:350px;
                            float:left;
                            padding:10px;        
                        } */
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
            <b><a href= "/UniqueSnacks/index.php/mainpage/customer_info_menu" > CUSTOMER INFO </a> </b>
            <br/>
            <b><a href= "/UniqueSnacks/index.php/mainpage/display_monthly_menu" > DISPLAY </a> </b>
            <br/> 
            <b><a href= "/UniqueSnacks/index.php/mainpage/calculate_salary_menu" > CALCULATE SALARY </a>  </b>
            <br/>
    </div> 