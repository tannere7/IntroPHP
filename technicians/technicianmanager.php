<!-- Evan Levine -->

<?php
include '../view/header.php';

// allow MySQLi error reporting and Exception handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}

try {

    // Connect to MySQL, select database
    $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");


    if(isset($_POST['hidden']) ) {
        //delete record, result of clicking a delete button
        $ID = $_POST['Email'];
        try {
            #$query = "DELETE FROM technicians WHERE email='$ID';";
            $query = mysqli_prepare($con, "DELETE FROM technicians WHERE email=?");
            mysqli_stmt_bind_param($query, "ss", $ID);
            mysqli_stmt_execute($query);
            $result = mysqli_query($con, $query);
        }catch(Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }
    } else{
        //insert record, completing add_technician
        $ID = $_POST['techid'];
        $FirstName = $_POST['FirstName'];
        $LastName = $_POST['LastName'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $Password = $_POST['Password'];

        $statement = "INSERT INTO technicians VALUES('$ID','$FirstName', '$LastName', '$Email', '$Phone','$Password')";

        $new = mysqli_query($con, $statement) or die('insert failed: '.mysqli_errno($con));

    }

    //In either case display records in products table
try {
    $query = "SELECT firstName,lastName,email,phone,password FROM technicians;";
    $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con));
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}
    //start echoing web page contents
    echo "<html><main><body class='td'>";
    echo "<h1>Technician List</h1>";
    echo "<table style='border:blue 1px dashed;'><tr>";
    echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>password</th>";

    // process result set.
    // first let's set table column headers.
    // each table field has field name, data type and length properties.
    // we only need the name
    echo "</tr>";

    // table column header done, now loop over result set.
    // Create a form for each record in result set.
    // Print field values for each record
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        echo "<tr>";
        echo "<form method='POST' action='technicianmanager.php'>";
        // inner loop. Print each field value for a result set record
        foreach ($line as $key => $value) {
            echo "<td>" . $value. "</td>";
        }

        // put delete button on form
        // use hidden form field
        echo "<input type='hidden' name='hidden' value='hidden'>";
        echo "<td><input type='submit' value='delete' name='foo'/></td></tr>";
        echo "</form>";
    } // end while

    echo "</table></body></main></html>";
    echo "<br>";
    echo "<a href=add_technician.php>Add Technician</a>";
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
} finally {
    // close connection
    mysqli_close($con);
}

?>
<?php include '../view/footer.php'; ?>