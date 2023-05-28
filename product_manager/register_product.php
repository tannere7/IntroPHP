<?php
include '../view/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['logincustomer']) || $_SESSION['logincustomer'] != "yes") {
    header("Location: ../login/customer_login.php");
    exit;
}

    try{
        $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");

        $ema = $_SESSION['emac'];
        $pw = $_SESSION['pwc'];

        try{$select = "SELECT * FROM customers WHERE email='".$ema."';";
            $statement = mysqli_query($con,$select);
            $row = mysqli_fetch_array($statement);

        } catch(Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }
        if (! empty($_POST['emailc'])) {
            $email = $_POST['emailc'];

            // allow MySQLi error reporting and Exception handling
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            try {
                // Perform SQL query
                $query = "SELECT * FROM Login WHERE email='$email'";
                $result = mysqli_query($con, $query);

                $rows = mysqli_num_rows($result);

                // if userid not in login table, redirect to error page and try again
                if ($rows < 1)
                    header("Location: error.php?message='email not found'");

            } catch (Exception $e) {
                $message = $e->getMessage();
                $code = $e->getCode();
            }
        }
    }catch(Exception $e){
        echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
    }
?>

<html>
<head>
    <title>Register Product</title>
</head>
<main>
    <body class="addform">
    <h1>Register Product</h1>
    <table>
        <form action="../Customer../login.php" method="POST" >

            <tr><td>Customer:</td><td><?php echo $row['firstName'].' '. $row['lastName'];?></td></tr>
        </form></table>
    <br>
<?php
echo'
<p>Product: </p>
<table> 
<form action="registered.php" method="POST">
<input type = "hidden" name = "cide" value = ';echo $row["customerID"];
echo '<tr>
<td> <select name="Product"</td>';


$products = "SELECT * FROM products;";
$productsq = mysqli_query($con,$products)or die('Query failed: ' . mysqli_errno($con));
$rows = mysqli_num_rows($productsq);

foreach ($productsq as $rows) {
    echo "<option >" . $rows['name'] ."</option>";
}

echo'
<br>    
<input type="submit" value="Register Product" name="Product1">

</form>
</table>
';
echo '<br> You are logged in as '.$ema.'.<br>';
echo '<form action="../Customer/logout.php" method="post" >
        <tr><td></td><td colspan="2"><input type="submit" value="logout"></td></tr>
        </form>
</body>
</main>
</html>';
if (mysqli_ping($con)) {
    // Connection is open
    mysqli_close($con);
}

include '../view/footer.php';
?>