<?php 
 
 //MySQLi (i for improved) or PDO (PDO for PHP Data Objects)

    //MySQLi

    $conn = MySQLi_connect('localhost', 'Bert', 'pass1234', 'berts_pizzas');

    // check connection to database
    if(!$conn){
        echo 'Database connection failed: ' . mysqli_connect_error();
    }

?>