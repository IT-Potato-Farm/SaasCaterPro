<?php  
include_once ('../config/database.php');

$database = new Database();
$db = $database ->getConnection();

if ($db) {
    echo "<h2 style='color: green; text-align: center;'>✅ Database Connection Successful!</h2>";
} else {
    echo "<h2 style='color: red; text-align: center;'>❌ Database Connection Failed!</h2>";
}
?>