<!-- Evan Levine-->
<?php
// enter new user in database
include '../view/header.php';
// Turn off default error reporting
error_reporting(0);

// allow MySQLi error reporting and Exception handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}
echo '
<html>
<body class="addform">

<h1>Get Customer</h1>
<p>You must enter the customers email address to select the customer.</p>
    <form action="create_incident.php" method="POST" >
        <tr><td>Email: </td><td> <input type="text" name="email" required="required"></td></tr>
       
            <input type="submit" value="Get Customer">
    </form>
    <br>

</body>
</html>'
;

if (! empty($_POST['email'])) {

    $email = $_POST['email'];

    // allow MySQLi error reporting and Exception handling
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        // Perform SQL query
        try {
            $query = mysqli_prepare($con, "SELECT * FROM customers WHERE email=? ");
            mysqli_stmt_bind_param($query, "ss", $email);
            mysqli_stmt_execute($query);
        }catch(Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }
        $result = mysqli_query($con, $query);

        $rows = mysqli_num_rows($result);

        // if email not in  customers table, redirect to error page and try again
        if ($rows < 1)
            header("Location: error.php?message='email not found'");

        //get table header names from SQL field names
        $finfo = mysqli_fetch_fields($result);
    } catch(Exception $e){
        echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
    }
}


include '../view/footer.php';
?>