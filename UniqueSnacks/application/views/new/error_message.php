<html>
    <h2>
        <?php
            echo $message; 
        ?>
    </h2>
    <body>
        <a href="/UniqueSnacks/index.php/mainpage">Main Page</a>
        <br>
        <script>
            function goBack() {
                window.history.back()
             }
        </script>
        <a href ="" onclick="goBack()">Back</a>
   </body>
</html>