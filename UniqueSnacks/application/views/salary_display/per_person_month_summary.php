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
      <div style="text-align: center; width:">
            <h3> Month Summary Of <?php echo $name ?> (<?php echo $id ?>) In <?php echo $month ?>, <?php echo $year?></h3>
        </div>
        <table class="boldtable">
            <tr>
                <th>ID</th>
                <th>AMOUNT</th>
            </tr>
            <?php 
                $total = 0;
                foreach($tableView as $row)
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
                        echo $row['amount'];
                        $total += $row['amount'];
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