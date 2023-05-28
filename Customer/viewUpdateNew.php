<!-- Form to view and update customer information. Includes a dropdown menu to update the customers country.
Can update any information within the form, and it will update within the SQL database-->
<?php
include '../view/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}

try {
    $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");

    $custID = $_POST['rownumber'];
//$sql = "SELECT * FROM customers WHERE customerID=$custID";

    $sql = mysqli_prepare($con, "SELECT * FROM customers WHERE customerID=?;");
    mysqli_stmt_bind_param($sql, "s", $custID);
    mysqli_stmt_execute($sql);
    $res = mysqli_stmt_get_result($sql);


//$res = mysqli_query($con, $sql) or die('query failed: '.mysqli_errno($con));;
    $row = mysqli_fetch_array($res);
}catch(Exception $e){
    echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
}

?>
<html>
<main>
    <head>
        <title>View/Update Customer</title>
    </head>
    <body>
    <h1>View/Update Customer</h1>
    <table>
        <form action = "customerNew.php" method = "POST">
            <input type = "hidden" name = "cid" value = "<?php echo $row["customerID"]; ?>">
            <tr><td>First Name:</td><td><input type = "text" name = "first" required minlength="1" maxlength="50" value="<?php echo $row["firstName"]; ?>"</td></tr>
            <tr><td>Last Name:</td><td><input type = "text" name = "last" required minlength="1" maxlength="50" value="<?php echo $row["lastName"]; ?>"</td></tr>
            <tr><td>Address:</td><td><input type = "text" name = "addr" required minlength="1" maxlength="50" value="<?php echo $row["address"]; ?>"</td></tr>
            <tr><td>City:</td><td><input type = "text" name = "cit" required minlength="1" maxlength="50" value="<?php echo $row["city"]; ?>"</td></tr>
            <tr><td>State:</td><td><input type = "text" name = "st" required minlength="1" maxlength="50" value="<?php echo $row["state"]; ?>"</td></tr>
            <tr><td>Postal Code:</td><td><input type = "text" name = "postco" required minlength="1" maxlength="20" value="<?php echo $row["postalCode"]; ?>"</td></tr>
            <tr>
                <td class="vt">Country: </td>
                <td><select name="country">
                        <?php
                        try{
                            $codecountry = $row["countryCode"];
                            //$statementcode = "SELECT * FROM countries WHERE countryCode = '$codecountry';";
                            $statementcode = mysqli_prepare($con,"SELECT * FROM countries WHERE countryCode =? ;" );
                            mysqli_stmt_bind_param($statementcode, "s", $codecountry);
                            mysqli_stmt_execute($statementcode);
                            $resultcountry = mysqli_stmt_get_result($statementcode);

                            //$resultcountry = mysqli_query($con, $statementcode) or die('query failed: '.mysqli_errno($con));;
                            $rowcountry = mysqli_fetch_array($resultcountry);

                        }catch(Exception $e){
                            echo '<h1>Database Error</h1>
                        <p>An error occurred while attempting to work with the database.</p>
                        <p>Message: </p>'.$e ->getMessage().'.';
                        }
                        ?>
                        <option value=" "><?php echo $rowcountry["countryName"];?></option>
                        <?php

                        try {
                            $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");

                            // variables for countries table
                            $countryName = "SELECT * FROM countries";
                            $country = mysqli_query($con, $countryName);
                            $rows = mysqli_num_rows($country);
                        }catch (Exception $e){
                            echo '<h1>Database Error</h1>
                            <p>An error occurred while attempting to work with the database.</p>
                            <p>Message: </p>'.$e ->getMessage().'.';
                        }


                        if ($rows < 1)
                            header("Location: error.php");

                        // loop over result set. Print a table row for each record
                        foreach ($country as $rows) {
                            echo "<option >" . $rows['countryName'] ."</option>";
                        }
                        ?>
                    </select>
                </td></tr>
            <tr><td>Phone:</td><td><input type = "tel" name = "phon" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}" value="<?php echo $row["phone"]; ?>"</td></tr>
            <tr><td>Email:</td><td><input type = "email" name = "ema" required minlength="1" maxlength="50" value="<?php echo $row["email"]; ?>"</td></tr>
            <tr><td>Password:</td><td><input type = "text" name = "pas" required minlength="6" maxlength="20" value="<?php echo $row["password"]; ?>"</td></tr>
            <tr><td></td><td colspan="2"><input type="submit" value="Update Customer" name = "update"></td></tr>
        </form>
    </table>
    <br>

    <a href="customerNew.php">Search Customers</a>
    </body>
</main>
</html>
<?php
include '../view/footer.php';
?>






