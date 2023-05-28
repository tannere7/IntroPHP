<!-- Julia Farry -->
<?php
require('../model/database.php');
include '../view/header.php';
echo "<!DOCTYPE html><html><main><body>";

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
    $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");

    if (! empty($_POST['productCode'])) {
        $Code = $_POST['productCode'];
        try {
            $query = "DELETE FROM products WHERE productCode='$Code';";
        }catch(Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }
        $result = mysqli_query($con, $query);
    }

    // Perform SQL query
    try {
        $query = "SELECT * FROM products;";
        $result = mysqli_query($con, $query);
    }catch(Exception $e){
        echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
    }

    //start echoing web page
    echo "<html><body>";
    echo "<h1 style='text-align:Left'>Product List</h1>";
    echo "<table style='border:black 2px solid;column-width: auto'><tr>";

    // process result set.
    // Create a form for each record in result set.
    // Print field values for each record
    echo "<tr><th>Code</th><th>Name</th><th>Version</th><th>Release Date</th></tr>";
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<form method='POST' action='original_index.php'>";
        // inner loop. Print each field value for a result set record
        foreach ($line as $key => $value) {
            echo "<td><input type='text' value='" . $value . "' name='" . $key . "' readonly/></td>";
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

<a href="add_product.php">Add Product</a>

<?php include '../view/footer.php'; ?>