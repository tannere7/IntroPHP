<!--Julia Farry-->
<?php
try {
    $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");

// variables for countries table
    $countryName = "SELECT * FROM countries";
    $country = mysqli_query($con, $countryName);
    $rows = mysqli_num_rows($country);
}catch (Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}


if ($rows < 1)
    header("Location: error.php");

// loop over result set. Print a table row for each record
foreach ($country as $rows) {
    echo "<option >" . $rows['countryName'] ."</option>";
}
?>





