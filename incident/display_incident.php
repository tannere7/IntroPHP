<!-- Tanner Eisenhut -->
<?php
require('../model/database.php');
include '../view/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}

echo "<html><main><body>
   <body class='addform'>";
$host = 'webdev.bentley.edu';
$db = 'jfarry';

//connection string
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$pdo = new PDO ($dsn, 'jfarry', '3333');
$sql = "SELECT incidentID, productCode, title, description FROM incidents WHERE dateClosed IS NULL; ";
$stmt = $pdo->query($sql);
$stmt->fetch();

echo "<table cellspacing='5' style ='border:blue 1px dashed;' ><tr>";
//get result set column headers
echo"
    <tr><th style = 'text-align: center'>IncidentID</th>
    <th style = 'text-align: center'>Product Code</th>
    <th class = 'specialcolumn' style = 'text-align: center'>Title</th>
    <th class = 'specialcolumn'>Description</th>
    

";

echo "</tr>";
$i = 0;
while ($row = $stmt->fetch())
{
    $i++;
    echo "<tr>";
    echo "<td style = 'text-align: center'>" . $row['incidentID'] . "</td><td>" . $row['productCode'] . "</td><td class = 'specialcolumn'>" . $row['title'] . "</td><td class = 'specialcolumn'>" . $row['description'] . "</td>";
    echo "</tr>";
}



echo "</table>
<p>There are $i open incidents reported in the database.</p>";


echo "</body></main>";
include '../view/footer.php';
