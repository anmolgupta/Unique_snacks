<html>
    <body>
        <?php echo 'Month :'.$month.'<br>'?>
        <?php echo 'Year :'.$year.'<br>'?>
        <?php echo 'ID :'.$id.'<br>'?>
        <table border="1">
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
         <?php
         echo "TOTAL AMOUNT : ".$total; 
         ?>
     </body>
</html>