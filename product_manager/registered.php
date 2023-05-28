<!-- Tanner -->

<?php
include '../view/header.php';



try {
    $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");
    $prod = $_POST['Product'];
    $customer = $_POST['cide'];

}catch (Exception $e) {
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>' . $e->getMessage() . '.';
}
try {
    $select = "SELECT * FROM products WHERE name = '" . $prod . "';";
    $statement = mysqli_query($con, $select);
    $row = mysqli_fetch_array($statement);
    $prodCode = $row['productCode'];

}
catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}
try {
    $insert = mysqli_prepare($con, "INSERT INTO registrations (customerID, productCode, registrationDate) VALUES(?,?,now());");
    mysqli_stmt_bind_param($insert, "ss", $customer, $prodCode);
    mysqli_stmt_execute($insert);
    //$update = mysqli_query($con, $insert) or die('insert failed: ' . mysqli_errno($con));

}catch(Exception $e) {
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>' . $e->getMessage() . '.';
}
echo'
<html><main><body>
<h2>Register Product</h2><br>
<form action="login.php" method="POST" >
     <td>Product (';echo $row['productCode'];?>) was registered successfully</td>
</body></main></html>
<?php
    if (mysqli_ping($con)) {
        // Connection is open
        mysqli_close($con);
    }
  include '../view/footer.php';
?>