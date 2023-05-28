<?php
require('../model/database.php');
include '../view/header.php';

echo "<!DOCTYPE html><html><main>
   <body class='td'>";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Connect to MySQL, select database
    $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");

    if (! empty($_POST['email'])) {
        $Code = $_POST['email'];
        try {
            $query = "';";
            $query = mysqli_prepare($con, "DELETE FROM technicians WHERE email=?");
            mysqli_stmt_bind_param($query, "ss", $Code);
            mysqli_stmt_execute($query);
        }catch(Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }
    }
    // Perform SQL query
    try {
        $query = "SELECT firstName,lastName,email,phone,password FROM technicians;";
        $result = mysqli_query($con, $query);
    }catch(Exception $e){
        echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
    }

    //start echoing web page
    echo "<html><main><body class='addform'>";
    echo "<h1 style='text-align:Left'>Technician List</h1>";
    echo "<table style='border:black 2px solid;'><tr>";

    // Create a form for each record in result set.
    // Print field values for each record
    echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Password</th>";
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        echo "<tr>";
        echo "<form method='POST' action='original_index.php'>";
        // inner loop. Print each field value for a result set record
        foreach ($line as $key => $value) {
            echo "<td>" . $value. "</td>";
        }


        // put delete button on form
        echo "<td><input type='submit' value='delete' name='foo'/></td></tr>";
        echo "</form>";
    }

    echo "</table></body></main></html>";
} catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
} finally {
    // close connection
    mysqli_close($con);
}

?>

    <a href="add_technician.php">Add Technician</a>

<?php include '../view/footer.php'; ?>