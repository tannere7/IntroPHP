<?php
include '../view/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['loginadmin']) || $_SESSION['loginadmin'] != "yes") {
    header("Location: administrator_login.php");
    exit;
}


$user = $_SESSION['adminloginuser'];


try{
    $con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");


    echo '
<main>
    <nav>

        <h2>Administrators</h2>
        <ul>
            <li><a href="../product_manager/index.php">Manage Products</a></li>
            <li><a href="../technicians/index.php">Manage Technicians</a></li>
            <li><a href="../Customer/customerNew.php">Manage Customers</a></li>
            <li><a href="../incident/get_customer.php">Create Incident</a></li>
            <li><a href="../under_construction.php">Assign Incident</a></li>
            <li><a href="../incident/display_incident.php">Display Incidents</a></li>
        </ul>
        <h2>Login Status</h2>
        <br> You are logged in as '.$user. '.<br>
        <form action="../Customer/logout.php" method="post" >
        <tr><td></td><td colspan="2"><input type="submit" name = "logoutbutton" value="logout"></td></tr>
        </form>
    </nav>
    </section></main>';
}
catch(Exception $e){
    echo '<h1>Database Error</h1>
  <p>An error occurred while attempting to work with the database.</p>
  <p>Message: </p>'.$e ->getMessage().'.';
}?>
<?php include '../view/footer.php'; ?>