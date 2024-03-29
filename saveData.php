<?php
include_once 'dbconfig.php';

if (isset($_POST['save']) && isset($_POST['data'])) {
    $data = $_POST['data'];
    if (!empty($data)) {
        $query = "INSERT INTO `post` (content, created_at) VALUES (?, NOW())";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 's', $data);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // SHOW DATA IN OUTPUT SECTION -- start coding
            $fetch_query = "SELECT * FROM `post` ORDER BY id DESC LIMIT 1";
            $fetch_result = mysqli_query($con, $fetch_query);

            if ($fetch_result) {
                // all data of textarea in output area
                while ($row = mysqli_fetch_assoc($fetch_result)) {
                    echo $row['content'];
                }
            } else {
                echo "Failed to fetch news from database.";
            }
        } else {
            echo "Failed to post news. Please try again later.";
        }
    } else {
        echo "Content cannot be empty.";
    }
}

?>