<?
 error_reporting(0);
$db = $_SESSION['db_name'];
$conn 		= new mysqli('localhost', 'root', '', $db);
//$conn 		= new mysqli('132.148.86.127', 'contracktor', 'Uve52^s6', $db);
$conn_admin     = new mysqli('132.148.86.127', 'contracktor', 'Uve52^s6','db_admin');

$conn->query("set time_zone = '-5:00' ");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
   }
?>