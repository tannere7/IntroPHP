<!-- Evan Levine -->
<?php
include '../view/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: ../login/administrator_login.php");
    exit;
}
echo'

<html>
<head>
<title>Add New Technician</title>
</head><main>
<body class="addform">
<h1>Add Technician</h1>
<table>
<form action="technicianmanager.php" method="POST" >
<input type="hidden" name="techid">
<tr><td>First Name:</td><td> <input type="text" name="FirstName" required="required"></td></tr>
<tr><td>Last Name:</td><td> <input type="text" name="LastName" required="required"></td></tr>
<tr><td>Email:</td><td> <input type="text" name="Email" required="required"></td></tr>
<tr><td>Phone:</td><td> <input type="text" name="Phone" required="required"></td></tr>
<tr><td>Password:</td><td> <input type="password" name="Password" required="required"></td></tr>
<tr><td></td><td colspan="2"><input type="submit" value="Add Technician"></td></tr>
</form>
</table>
<a href="index.php">View Technician List</a>
</body></main>
</html>
';
include '../view/footer.php';
?>


