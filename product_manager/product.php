<?php
try{
$con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");

// variables for countries table
try {
    $prodName = "SELECT * FROM products";
    $prod = mysqli_query($con,$prodName)or die('Query failed: ' . mysqli_errno($con));
    $rows = mysqli_num_rows($prod);
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}

if ($rows < 1)
    header("Location: error.php");

// loop over result set. Print a table row for each record
foreach ($prod as $rows) {
    echo "<option >" . $rows['name'] ."</option>";
}}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}
?>


