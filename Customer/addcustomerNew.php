<!-- Form to view and update customer information. Includes a dropdown menu to update the customers country.
Can update any information within the form, and it will update within the SQL database-->
<?php
include '../view/header.php'

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
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
            <input type = "hidden" name = "cid">
            <tr><td>First Name:</td><td><input type = "text" name = "first2" required minlength="1" maxlength="50" </td></tr>
            <tr><td>Last Name:</td><td><input type = "text" name = "last2" required minlength="1" maxlength="50"</td></tr>
            <tr><td>Address:</td><td><input type = "text" name = "addr2" required minlength="1" maxlength="50"</td></tr>
            <tr><td>City:</td><td><input type = "text" name = "cit2" required minlength="1" maxlength="50" </td></tr>
            <tr><td>State:</td><td><input type = "text" name = "st2" required minlength="1" maxlength="50" </td></tr>
            <tr><td>Postal Code:</td><td><input type = "text" name = "postco2" required minlength="1" maxlength="20"</td></tr>
            <tr>
                <td class="vt">Country: </td>
                <td><select name="country2">

                        <?php

                        include("country.php");
                        ?>
                    </select>
                </td></tr>
            <tr><td>Phone:</td><td><input type = "tel" name = "phon2" pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}"</td></tr>
            <tr><td>Email:</td><td><input type = "email" name = "ema2" required minlength="1" maxlength="50"</td></tr>
            <tr><td>Password:</td><td><input type = "text" name = "pas2" required minlength="6" maxlength="20"</td></tr>
            <tr><td></td><td colspan="2"><input type="submit" value="Add Customer" name = "add"></td></tr>
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
