<!-- Evan Levine -->
<?php
include '../view/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['techlogin']) AND $_SESSION['techlogin'] = "yes") {
    header("Location: select_incident.php");
    exit;
}

//try{
  // if ($_SESSION['techlogin'] !== "yes") throw new Exception("user not logged in");
//} catch (Exception $e) {
  //  $message = $e->getMessage();
  // $code = $e->getCode();
 // header("Location: error.php?code=$code&message=$message");
//}

    if(isset($_POST['submittech'])) {
        try {
            $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");

            $ema = $_POST['emailtech'];
            $pw = $_POST['passwordtech'];

            $_SESSION['emailtech1'] = $ema;
            $_SESSION['passtech1'] = $pw;


            $query = mysqli_prepare($con, "SELECT * FROM technicians WHERE email = ? AND password =?;");

            mysqli_stmt_bind_param($query, "ss", $ema, $pw);
            mysqli_stmt_execute($query);
            $techperson = mysqli_stmt_get_result($query);
            $num = mysqli_num_rows($techperson);


            if (mysqli_num_rows($techperson) == 1) {
                $_SESSION['techlogin'] = "yes";
                header("Location: select_incident.php");
            }
            else  {
                header("Location: technician_login.php");
            }
            //else header("Location: index.php");


        } catch (Exception $e) {
            $message = $e->getMessage();
            $code = $e->getCode();
            header("Location: error.php?code=$code&message=$message");
        }

    }



echo '
<!DOCTYPE html>
<html>
<head>
<title>Technician Login</title>
</head>
<main>
<body class="addform">
<h1>Technician Login</h1>
<table>
<form action="technician_login.php" method="post">
<p>You must login before you can update an incident.</p>
<tr><td >Email:</td><td><input type="text" name="emailtech" placeholder="email" required="required"></td></tr>
<tr><td >Password:</td><td><input type="password" name="passwordtech" placeholder="password" required="required"></td></tr>
<tr><td></td><td colspan="2"><input type="submit" name = "submittech" value="Login"></td></tr>
</form> 
</table>
</body>
</main>
</html>
';


include '../view/footer.php';