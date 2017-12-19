<?php 
include "connection.php"; /** calling of connection.php that has the connection code **/ 

$id = $_GET['id']; /** get the student ID ***/

mysql_query("DELETE FROM student_record where ID = '$id'"); /** execute the sql delete code **/

header("Location: delete.php"); /** redirect to delete.php **/


