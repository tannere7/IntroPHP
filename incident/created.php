<!-- Julia farry -->

<?php
include '../view/header.php';

try{
$con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");
$prod = $_POST['Product'];
$customer = $_POST['cide'];
try{
    $query = mysqli_prepare($con, "SELECT * FROM products WHERE name=?");
    mysqli_stmt_bind_param($query, "ss", $prod);
    mysqli_stmt_execute($query);
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}
$statement = mysqli_query($con,$query);
$row = mysqli_fetch_array($statement);
$enddate = null;
$title = $_POST['title'];
$desc = $_POST['description'];


$insert = "INSERT INTO incidents (customerID, productCode, dateOpened,dateClosed,title,description) VALUES('$customer','$prod',now(),'$enddate','$title','$desc');";
$update = mysqli_query($con, $insert) or die('insert failed: '.mysqli_errno($con));

echo'
<html><main><body>
<h2>Create Incident</h2><br>
<form action="create_incident.php" method="POST" >
     <td>This incident was added to our database</td>
</body></main></html>
';
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}
include '../view/footer.php';
?>