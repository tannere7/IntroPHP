<?php include '../view/header.php'; ?>
<main>
<nav>
    <h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
   
    <p>Error message: <?php echo $error_message; ?></p>
    </nav>
</main>
<?php include '../view/footer.php'; ?>