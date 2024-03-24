<?php 
include('teacher_session.php');  ?>

<?php
include('dbcon.php');
include('initialize.php');
?>
             
             <?php
if (isset($_POST['add_book'])) {
    // Handle the form submission
    
    // Establish a database connection (assuming you have already done this)
    include("dbcon.php");

    $title = $_POST['title'];
    $description = $_POST['desc'];
    $author = $_POST['author'];
    $category_id = $_POST['category'];
    $publication_year = $_POST['publication_year'];
    $call_number = $_POST['call_number'];

    // Handle the uploaded photo
    if (isset($_FILES['book_cover']) && isset($_FILES['file_path'])) {
        $coverFile = $_FILES['book_cover'];
        $fileFile = $_FILES['file_path'];

        // Check for errors
        if ($coverFile['error'] === UPLOAD_ERR_OK && $fileFile['error'] === UPLOAD_ERR_OK) {
            $uploadPath = '../libraryimages/';  // Specify the directory where you want to store uploaded images
            $fileUploadPath = '../libraryfiles/';  // Specify the directory where you want to store uploaded files

            // Generate unique file names
            $newCoverFileName = 'book_cover_' . uniqid() . '_' . $coverFile['name'];
            $newFileFileName = uniqid() . '_' . $fileFile['name'];

            // Set the destination paths
            $coverDestination = $uploadPath . $newCoverFileName;
            $fileDestination = $fileUploadPath . $newFileFileName;

            // Move the uploaded files to their respective directories
            if (move_uploaded_file($coverFile['tmp_name'], $coverDestination) && move_uploaded_file($fileFile['tmp_name'], $fileDestination)) {
                // File uploads were successful, set book_status to 2
                $book_status = 2;

                // Insert the book data into the database
                $insertQuery = "INSERT INTO booklist (book_title, book_description, author, category_id, publication_year, call_number, book_cover, file_path, book_status) 
                                VALUES ('$title', '$description', '$author', $category_id, $publication_year, $call_number, '$coverDestination', '$fileDestination', $book_status)";

                if (mysqli_query($conn, $insertQuery)) {
                    // Book added successfully
                    echo 'Book added successfully.';
                } else {
                    echo 'Error adding the book: ' . mysqli_error($conn);
                }
            } else {
                echo 'Error moving the files to the destination.';
            }
        } else {
            echo 'File upload error: ' . $coverFile['error'] . ' / ' . $fileFile['error'];
        }
    }
}
?>
