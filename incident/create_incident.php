<?php
include '../view/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}

$con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");

$ema = $_POST['email'];

$rows = null;

$cuid = null;

// allow MySQLi error reporting and Exception handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // $select = "SELECT * FROM customers WHERE email='$ema';";
    $select = mysqli_prepare($con, "SELECT * FROM customers WHERE email=?;");
    mysqli_stmt_bind_param($select, "s", $ema);
    mysqli_stmt_execute($select);

    $result = mysqli_stmt_get_result($select);

    $numrows = mysqli_num_rows($result);

    // if userid not in login table, redirect to error page and try again
    if ($numrows < 1)
        header("Location: error.php?message='email not found'");
    $rows = $result -> fetch_assoc();
    $cuid = $rows['customerID'];

} catch (Exception $e) {
    $message = $e->getMessage();
    $code = $e->getCode();
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
        <form action="get_customer.php" method="POST" >

            <tr><td>Customer:</td><td><?php echo $rows['firstName'].' '. $rows['lastName'];?></td></tr>
        </form></table>
    <br>

<?php
echo'
<p>Product: </p>
<table> 
<form action="created.php" method="POST">
<input type = "hidden" name ="cide" value="$cuid">

<td> <select name="Product">';

try {
    //$products = "SELECT productCode FROM registrations WHERE customerID='$cuid';";
    $products = mysqli_prepare($con,"SELECT productCode FROM registrations WHERE customerID=?;" );
    mysqli_stmt_bind_param($products, "s", $cuid);
    mysqli_stmt_execute($products);
    $productsq = mysqli_stmt_get_result($products);

    //$productsq = mysqli_query($con, $products) or die('Query failed: ' . mysqli_errno($con));
    $rows = mysqli_num_rows($productsq);
}catch (Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}
foreach ($productsq as $rows) {
    echo "<option >" . $rows['productCode'] ."</option>";
}

echo' </select></td>';
echo'
<br>    
<tr><td>Title: </td><td> <input type="text" name="title" ></td></tr>
<tr><td>Description: </td><td> <textarea rows="5" cols="30" name="description"> Enter some text here. </textarea><br><input type="submit" value="Create Incident" name="incident"></td></tr>
</form>
</table>
</body>
</main>
</html>
';
include '../view/footer.php';
?>