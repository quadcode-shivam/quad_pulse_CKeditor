<?php
include_once 'dbconfig.php';

// Check if a specific record needs to be edited
if (isset($_POST['edit'])) {
    // Fetch the latest record from the database
    $fetch_query = "SELECT content FROM `post` ORDER BY id DESC LIMIT 1";
    $fetch_result = mysqli_query($con, $fetch_query);

    if ($fetch_result) {
        if (mysqli_num_rows($fetch_result) > 0) {
            // Get the content from the fetched record
            $row = mysqli_fetch_assoc($fetch_result);
            $content = $row['content'];
            echo $content;
        } else {
            echo "No records found in the database.";
        }
    } else {
        echo "Failed to fetch data from the database: " . mysqli_error($con);
    }
}
?>
