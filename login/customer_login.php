<!-- McKenzie Sullivan and Julia Farry-->
<?php
include '../view/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['logincustomer']) AND $_SESSION['logincustomer'] = "yes") {
    header("Location: ../product_manager/register_product.php");
    exit;
}
try{
    $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");
}catch (Exception $e) {
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>' . $e->getMessage() . '.';
}
//if already log in, rediredct

// First, check if the form has been submitted
    if (isset($_POST['submitcustomer'])) {
        // Get the username and password from the form
        $ema = $_POST['emailc'];
        $password = $_POST['passwordc'];
        try {
            // Connect to the database


            // Check if the username and password are correct
            $query1 = mysqli_prepare($con, "SELECT * FROM customers WHERE email=? AND password=?;");

            mysqli_stmt_bind_param($query1, 'ss', $ema, $password);
            mysqli_stmt_execute($query1);

            $result = mysqli_stmt_get_result($query1);

            if (mysqli_num_rows($result) == 1) {


                $_SESSION['logincustomer'] = 'yes';
                $_SESSION['emac'] = $ema;
                $_SESSION['pwc'] = $password;
                header("Location: ../product_manager/register_product.php");
            } else {
                // The login was unsuccessful, so display an error message
                $error = 'Invalid username or password';

            }} catch (Exception $e) {
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>' . $e->getMessage() . '.';
        }
    }
echo '
<!DOCTYPE html>
<html>
<main>
<body class="addform">
<h1>Customer Login</h1>
<table>
<form action="customer_login.php" method="post" >
<p>You must login before you can register a product.</p>
<tr><td>Email:</td><td> <input type="text" name="emailc" placeholder="email" required="required"></td></tr>
<tr><td>Password:</td><td> <input type="password" name="passwordc" placeholder="password" required="required"></td></tr>
<tr><td></td><td><input type="submit" name = "submitcustomer" value="Login"></td></tr>
</form>
</table>
</body>
</main>
</html>
';
if (mysqli_ping($con)) {
    // Connection is open
    mysqli_close($con);
}

include '../view/footer.php';