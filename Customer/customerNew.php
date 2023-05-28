<!-- Tanner -->
<!-- Manage customers from homepage. Searches for customer last name,
 then customer information can be viewed or updated -->
<?php

require('../model/database.php');
include '../view/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}
echo'
<head>
    <title>SportsPro Technical Support</title>
    <link rel=stylesheet" type="text/css"
          href="../css/main.css">
</head>';


echo "<html><main>
   <body class='addform'>";

try{
    $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");
// Create search box for customer last name
    echo "<h1>"."Customer Search"."</h1>";
    echo "<table><form action='customerNew.php' method='Post'>";


    echo"
<td class='addform'>Last Name: </td><td><input type='text' name='LastName'/></td>
<td><input type='submit' name = 'search' value = 'Search'></td>
</form> </table>";




    echo "<h1>"."Add New Customer"."</h1>";
    echo "<table><form action = 'viewUpdateAdd.php' method = 'Post'><input type = 'submit' name = 'addnew' value = 'Add Customer'>
</form></table>
";

    // Output results from search

    if(isset($_POST['update'])){
        $cuid = $_POST['cid'];
        $firstn = $_POST['first'];
        $lastn = $_POST['last'];
        $addres = $_POST['addr'];
        $ci = $_POST['cit'];
        $stat = $_POST['st'];
        $posc = $_POST['postco'];
        $conc = $_POST['country'];
        $pho = $_POST['phon'];
        $em = $_POST['ema'];
        $pa = $_POST['pas'];
        try {
            //$concodestatement = "SELECT * FROM countries WHERE countryName = '$conc';";
            //$concode = mysqli_query($con, $concodestatement) or die('query failed: '.mysqli_errno($con));

            $concodestatement = mysqli_prepare($con,"SELECT * FROM countries WHERE countryName = ?;");
            mysqli_stmt_bind_param($concodestatement, "s", $conc);
            mysqli_stmt_execute($concodestatement);
            $concode = mysqli_stmt_get_result($concodestatement);

            $line = mysqli_fetch_array($concode);
            $code = $line['countryCode'];


            //$statement = "UPDATE customers SET firstName = '$firstn', lastName = '$lastn', address = '$addres', city = '$ci', state = '$stat', postalCode = '$posc', countryCode = '$code', phone = '$pho', email = '$em', password = '$pa' WHERE customerID = '$cuid';";
            //$update = mysqli_query($con, $statement) or die('update failed: '.mysqli_errno($con));

            $statement = mysqli_prepare($con, "UPDATE customers SET firstName = ?, lastName =?, address = ?, city = ?, state = ?, postalCode = ?, countryCode = ?, phone = ?, email = ?, password = ? WHERE customerID = ?;");
            mysqli_stmt_bind_param($statement, "ssssssssssi", $firstn, $lastn, $addres, $ci, $stat, $posc, $code, $pho, $em, $pa, $cuid);
            mysqli_stmt_execute($statement);
            $update = mysqli_stmt_get_result($statement);

        }catch (Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }}

    if(isset($_POST['add'])){
        $newcuid = NULL;
        $firstn = $_POST['first2'];
        $lastn = $_POST['last2'];
        $addres = $_POST['addr2'];
        $ci = $_POST['cit2'];
        $stat = $_POST['st2'];
        $posc = $_POST['postco2'];
        $conc = $_POST['country2'];
        $pho = $_POST['phon2'];
        $em = $_POST['ema2'];
        $pa = $_POST['pas2'];
        try {
            //$concodestatement = "SELECT * FROM countries WHERE countryName = '$conc';";
            //$concode = mysqli_query($con, $concodestatement) or die('query failed: '.mysqli_errno($con));

            $concodestatement = mysqli_prepare($con,"SELECT * FROM countries WHERE countryName = ?;");
            mysqli_stmt_bind_param($concodestatement, "s", $conc);
            mysqli_stmt_execute($concodestatement);
            $concode = mysqli_stmt_get_result($concodestatement);

            $line = mysqli_fetch_array($concode);
            $code = $line['countryCode'];


            //$statement = "UPDATE customers SET firstName = '$firstn', lastName = '$lastn', address = '$addres', city = '$ci', state = '$stat', postalCode = '$posc', countryCode = '$code', phone = '$pho', email = '$em', password = '$pa' WHERE customerID = '$cuid';";
            //$update = mysqli_query($con, $statement) or die('update failed: '.mysqli_errno($con));

            $statement = mysqli_prepare($con, "INSERT INTO customers (customerID, firstName, lastName, address, city, state, postalCode, countryCode, phone, email, password) VALUES(?,?,?,?,?,?,?,?,?,?,?);");
            mysqli_stmt_bind_param($statement, "issssssssss", $newcuid, $firstn, $lastn, $addres, $ci, $stat, $posc, $code, $pho, $em, $pa);
            mysqli_stmt_execute($statement);
            $update = mysqli_stmt_get_result($statement);

        }catch (Exception $e){
            echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
        }}


    else{
        if (!empty($_POST['LastName'])){
            $lastname = $_POST['LastName'];

            try {

                //$query = "SELECT * FROM customers WHERE lastname like '%$lastname%';";
                //$result = mysqli_query($con, $query) or die('insert failed: '.mysqli_errno($con));

                $query = mysqli_prepare($con, "SELECT * FROM customers WHERE lastname like ?;");
                mysqli_stmt_bind_param($query, "s", $lastname);
                mysqli_stmt_execute($query);
                $result = mysqli_stmt_get_result($query);

                echo "<h1>"."Results"."</h1>";

                if ($result->num_rows > 0) {
                    echo "<table style ='border:blue 1px dashed;'><tr>";
                    echo "<form method='POST' action='ViewUpdateAdd.php'>";
                    echo "<tr><th>Name</th><th>Email Address</th><th>City</th><th></th>";
                    echo "</tr><tr>";
                    while ($row = $result->fetch_assoc()) {


                        echo "<td>";
                        echo $row["firstName"] . " " . $row["lastName"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["email"];
                        echo "</td>";
                        echo "<td>";
                        echo $row["city"];
                        ?>
                        </td><td colspan='2'><button name ='rownumber' value = "<?php echo $row["customerID"]; ?>">View</button>
                        <?php
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                } else {
                    echo "0 Records";
                }
            } catch (Exception $e){
                echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
            } finally {
                // close connection
                mysqli_close($con);
            }
        }
    }}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}



include '../view/footer.php';