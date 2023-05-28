<?php include 'header.php';


$con = mysqli_connect("webdev.bentley.edu", "teisenhut", "5656", "teisenhut");

?>
<main>
    <nav>

        <h2>Main Menu</h2>
        <ul>
            <li><a href="login/administrator_login.php">Administrators</a></li>
            <li><a href="login/technician_login.php">Technicians</a></li>
            <li><a href="login/customer_login.php">Customers</a></li>

        </ul>
    </nav>
    </section></main>
<?php

if (mysqli_ping($con)) {
    // Connection is open
    mysqli_close($con);
}

include 'view/footer.php'; ?>
