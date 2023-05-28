<!-- Julia Farry -->
<?php
include '../view/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

#try{
 #   if ($_SESSION['login'] !== "yes") throw new Exception("user not logged in");
#} catch (Exception $e) {
 #   $message = $e->getMessage();
  #  $code = $e->getCode();
   # header("Location: error.php?code=$code&message=$message");
#}
if (!isset($_SESSION['techlogin']) || $_SESSION['techlogin'] != "yes") {
    header("Location: technician_login.php");
    exit;
}



try{
    $con = mysqli_connect("webdev.bentley.edu", "jfarry", "3333", "jfarry");

    //$ema = $_POST['emailtech'];
    $ema = $_SESSION['emailtech1'];

    //$pw = $_POST['passwordtech'];
    $pw = $_SESSION['passtech1'];

    try{$query = mysqli_prepare($con, "SELECT * FROM technicians WHERE email=? And password=?");
        mysqli_stmt_bind_param($query, "ss", $ema, $pw);
        mysqli_stmt_execute($query);
       $result = mysqli_stmt_get_result($query);
    }catch(Exception $e){
        echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>'.$e ->getMessage().'.';
    }
    $record=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $_SESSION['ID'] = $record['techID'];
    $ID = $_SESSION['ID'];

    //$header = "SELECT * FROM incidents WHERE techID=$ID";
    $header = mysqli_prepare($con, "SELECT * FROM incidents WHERE techID=?;");
    mysqli_stmt_bind_param($header, "s", $ID);
    mysqli_stmt_execute($header);
    $results = mysqli_stmt_get_result($header);

    $numr = mysqli_num_rows($results);
    //$results = mysqli_query($con, $header);

    echo '
<main>
    <nav>
        <h2>Select Incident</h2>
        <table>';


    if ($numr == 0){
        echo '<br> There are no open incidents for this technician. <br>';
        echo '<br>';
        echo "<a href=select_incident.php>Refresh List of Incidents</a>";
        echo '<br>';
    }
    if ($numr >0) {
     // loop over result set. Print a table row for each record
     while ($line = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        // inner loop. Print each table field value for a record
        echo"<tr>";
         foreach ($line as $col_value) {
            echo "\t\t<td>$col_value</td>\n";
        }
        echo "\t</tr>\n";}}
        echo "</table>\n";

        echo '<br> You are logged in as ' . $ema . '.<br>';
        echo '<br>
        <form action="../Customer/logout.php" method="post" >
        <tr><td></td><td colspan="2"><input type="submit" name = "logoutbutton" value="logout"></td></tr>
        </form>
    </nav>
    </section></main>';

} catch(Exception $e){
        echo '<h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: </p>' . $e->getMessage() . '.';

}


?>

<?php include '../view/footer.php'; ?>