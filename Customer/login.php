<!-- McKenzie Sullivan -->

<?php
// enter new user in database
require ("../model/database.php");
include '../view/header.php';
// Turn off default error reporting

error_reporting(0);

// allow MySQLi error reporting and Exception handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");

    echo '
<html><main>
<body class="addform">
<title>Login</title>
<h1>Customer Login</h1>
<h2>You must log in before you can register a product</h2>
    <form action="../product_manager/register_product.php" method="POST" >
        <tr><td>Email</td><td> <input type="text" name="email" required="required"></td></tr>
            <input type="submit" value="Login">
    </form>
    <br>

</body>
</main>
</html>'
    ;

    if (! empty($_POST['email'])) {

        $email = $_POST['email'];

        // allow MySQLi error reporting and Exception handling
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            // Perform SQL query
            $query = "SELECT * FROM customers WHERE email='$email'";
            $result = mysqli_query($con, $query);

            $rows = mysqli_num_rows($result);

            // if email not in  customers table, redirect to error page and try again
            if ($rows < 1)
                header("Location: error.php?message='email not found'");

            //get table header names from SQL field names
            $finfo = mysqli_fetch_fields($result);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
        }
    }}catch(Exception $e){
    include(database_error.php);
}


include '../view/footer.php';
?>