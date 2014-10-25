<html>
    <body>
        <?php echo 'Month :'.$month.'<br>'?>
        <?php echo 'Year :'.$year.'<br>'?>

        <table border="1">
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
         <?php
         echo "TOTAL AMOUNT : ".$total; 
         ?>
     </body>
</html>