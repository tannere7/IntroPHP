<?php
include '../view/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}

// allow MySQLi error reporting and Exception handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    // Connect to MySQL, select database
    $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");


    if(isset($_POST['hidden']) ) {
        //delete record, result of clicking a delete button
        $Code = $_POST['productCode'];
        try {
            $query = mysqli_prepare($con, "DELETE FROM products WHERE productCode=? ");
            #$query = "DELETE FROM products WHERE productCode='$Code';";
            mysqli_stmt_bind_param($query, "ss", $code);
            mysqli_stmt_execute($query);
            $result = mysqli_query($con, $query);

        }catch(Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }
    } else{
        //insert record, completing add_product
        $Code = $_POST['Code'];
        $Name = $_POST['Name'];
        $Version = $_POST['Version'];
        $ReleaseDate = $_POST['ReleaseDate'];

        $statement = "INSERT INTO products VALUES('$Code', '$Name', '$Version', '$ReleaseDate')";

        $new = mysqli_query($con, $statement) or die('insert failed: '.mysqli_errno($con));

    }

    //In either case display records in products table
try {
    $query = "SELECT * FROM products;";
    $result = mysqli_query($con, $query) or die('Query failed: ' . mysqli_errno($con));
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}

    //start echoing web page contents
    echo "<html><main><body>";
    echo "<h1>Product List</h1>";
    echo "<table style='border:blue 1px dashed;'><tr>";
    echo "<tr><th>Code</th><th>Name</th><th>Version</th><th>Release Date</th><th></th>";
    echo "</tr>";
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        echo "<tr>";
        echo "<form method='POST' action='productmanager.php'>";
        // inner loop. Print each field value for a result set record
        foreach ($line as $key => $value) {
            echo "<td><input type='text' value='" . $value . "' name='" . $key . "'/></td>";
        }

        // put delete button on form
        // use hidden form field
        echo "<input type='hidden' name='hidden' value='hidden'>";
        echo "<td><input type='submit' value='delete' name='foo'/></td></tr>";
        echo "</form>";
    } // end while

    echo "</table></body></html>";
    echo "<br>";
    echo "<a href=add_product.php>Add Product</a>";
}
catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
} finally {
    // close connection
    mysqli_close($con);
}

?>
<?php include '../view/footer.php'; ?>