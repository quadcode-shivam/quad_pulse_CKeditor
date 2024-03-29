<?php
// Check if file upload operation is initiated
if(isset($_FILES['upload']['name'])) {
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];

    // Check if the file size is within the limit (1 MB)
    if ($_FILES["upload"]["size"] > 1000000) {
        // Return error response if file size exceeds the limit
        echo json_encode(array(
            'error' => 'Image is too large: Upload image under 1 MB.'
        ));
    } 
    else {
        // Generate a unique filename to prevent overwriting
        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_image_name = uniqid() . '.' . $extension;

        // Move the uploaded file to the desired location
        if(move_uploaded_file($file, 'uploads/' . $new_image_name)) {
            // Construct the URL of the uploaded image
            $url = 'http://127.0.0.1/ckeditor/uploads/' . $new_image_name; 
            // Provide a success response
            echo json_encode(array(
                'uploaded' => 1,
                'fileName' => $new_image_name,
                'url' => $url
            ));
        } else {
            // Return error response if there's an issue moving the uploaded file
            echo json_encode(array(
                'error' => 'Error moving uploaded image.'
            ));
        }
    }
} else {
    // Return error response if no file is uploaded
    echo json_encode(array(
        'error' => 'No file uploaded.'
    ));
}
?>
