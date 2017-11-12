<?php
$connection = mysqli_connect('localhost', 'zerfca_echo', 'echolakecamp1956!');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'zerfca_echo');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>