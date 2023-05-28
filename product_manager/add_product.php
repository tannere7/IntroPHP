
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
<title>Add New Product</title>
</head>
<main>
<body class="addform">
<h1>Add Product</h1>
<table>
<form action="productmanager.php" method="post" >
<tr><td>Code:</td><td> <input type="text" name="Code" required="required"></td></tr>
<tr><td>Name:</td><td> <input type="text" name="Name" required="required"></td></tr>
<tr><td>Version:</td><td> <input type="number" name="Version" required="required"></td></tr>
<tr><td>Release Date:</td><td> <input type="date" name="ReleaseDate" required="required" data-sort="YYYYMMDD"></td><td>Use yyyy-mm-dd format</td></tr>
<tr><td></td><td colspan="2"><input type="submit" value="Add Product"></td></tr>
</form>
</table>
<a href="index.php">View Product List</a>
</body>
</main>
</html>
';
include '../view/footer.php';
?>