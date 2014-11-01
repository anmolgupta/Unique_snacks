<html>
    
    
    <style>
        .boldtable, .boldtable th
{
border: 1px solid black;
font-family:sans-serif;
font-size:15pt;
color:#000000;
padding: 3px;
background-color:#ffffff;
}
.boldtable td
{
   border: 1px solid black;
font-family:sans-serif;
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
</style>
    <body>
        <div style="text-align: center;">
            <h1>Summary Of <?php echo $month?>,  <?php echo $year?> </h1>
        </div>

        <table class="boldtable">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>AMOUNT</th>
                <th>ACCOUNT NO</th>
                <th>NAME OF BANK</th>
            </tr>
            <?php 
                $total = 0;
                foreach($rows as $row)
                {
            ?>
            <tr>
                <td>
                    <?php 
                        echo $row['id'];
                    ?>
                 </td>
                 <td>
                    <?php 
                        echo $row['name'];
                    ?>
                 </td>
                 <td>
                    <?php 
                        echo $row['incentive'];
                        $total += $row['incentive'];
                    ?>
                 </td>
                  <td>
                    <?php 
                        echo $row['account_no'];
                    ?>
                 </td>
                  <td>
                    <?php 
                        echo $row['name_of_bank'];
                    ?>
                 </td>
            </tr>
            <?php
                } 
            ?>
         </table>
               <h3> TOTAL AMOUNT :  <?php echo $total ?></h3>
               <a href="/UniqueSnacks/index.php/mainpage">Main Menu </a>
     </body>
</html>