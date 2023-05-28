<?php
include '../view/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['loginadmin']) AND $_SESSION['loginadmin'] = "yes") {
    header("Location: admin_menu.php");
    exit;
}


// First, check if the form has been submitted
    if (isset($_POST['submitadmin'])) {
        // Get the username and password from the form
        $username = $_POST['nameadmin'];
        print_r($username);
        $password = $_POST['passworda'];
        try {
            // Connect to the database
            $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");

            // Check if the username and password are correct
            $query1 = mysqli_prepare($con, "SELECT * FROM administrators WHERE username=? AND password=?;");
            mysqli_stmt_bind_param($query1, 'ss', $username, $password);
            mysqli_stmt_execute($query1);

            $result = mysqli_stmt_get_result($query1);

            if (mysqli_num_rows($result) == 1) {

                // Get the user information from the database
                //$user = mysqli_fetch_assoc($result);
                $_SESSION['loginadmin'] = 'yes';
                $_SESSION['adminloginuser'] = $username;
                header("Location: admin_menu.php");
            } else {
                // The login was unsuccessful
                header("Location: administrator_login.php");

            }
        } catch (Exception $e) {
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
<h1>Admin Login</h1>
<table>
<form action="administrator_login.php" method="post" >
<tr><td>Username:</td><td> <input type="text" name="nameadmin" placeholder="User Name" required="required"></td></tr>
<tr><td>Password:</td><td><input type="password" name="passworda" placeholder="password" required="required"></td></tr>
<tr><td></td><td><input type="submit" name = "submitadmin" value="Login"></td></tr>
</form> 
</table>
</body>
</main>
</html>
';


include '../view/footer.php';