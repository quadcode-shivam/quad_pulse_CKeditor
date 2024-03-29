<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>News Post</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="ckeditor1/ckeditor.js"></script>
    <style>
    .edit_btn {
        background: rgba(0, 128, 0, 0.3);
        color: green;
        font-weight: 700;
        cursor: pointer;
    }

    textarea {
        tab-index: 0;
    }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-sm-6">
            <!-- editor -->
            <form id="editor" class="border" method="POST">
                <h3 class="bg-secondary text-center text-light">Post your News</h3>
                <textarea name="content" placeholder="textarea placeholder" id="content"></textarea>
                <input id="save" class="btn btn-success w-100" type="button" value="Submit">
                <input id="update" class="btn btn-success w-100" type="button" value="Update">
            </form>
        </div>
        <div class="col-sm-6">
            <!-- output after submission -->
            <div style="height: 780px;" class="border">
                <h3 class="bg-secondary text-center text-light">Output</h3>
                <div class="mb-3 ms-3">
                    <input type="button" id="edit" name="edit" class="border-1 rounded text-center edit_btn"
                        value="You Can Edit !">
                </div>
                <div id="output">
                </div>
            </div>
        </div>
    </div>

    <script>
    CKEDITOR.replace('content', {
       
        height: 600,
        filebrowserUploadUrl: 'upload.php', // Ensure this URL matches your upload.php file
    });

    $(document).ready(function() {
      
        $("#update").hide();
        $("#save").show();
        $(document).on("click", "#save", function(e) {
            e.preventDefault(); // prevent the default form submission

            var data = CKEDITOR.instances.content.getData(); // get the content from CKEditor

            $.ajax({
                url: 'saveData.php',
                type: 'POST',
                data: {
                    'save': 1,
                    'data': data,
                },
                success: function(response) {
                    Swal.fire("Your post is created");
                    $("#output").html(response); // Update the HTML content of #output
                    console.log(response); // log the response to the console
                    CKEDITOR.instances.content.setData(''); // Clear the CKEditor textarea
                }
            });
        });

        $(document).on("click", "#edit", function(e) {
            var edit = $("#edit").val();
            $("#save").hide();
            $("#update").show();
            $.ajax({
                url: 'fetchData.php',
                type: 'POST',
                data: {
                    edit: edit,
                },
                success: function(response) {
                    alert("Edit functionality triggered!");
                    CKEDITOR.instances.content.setData(response);
                }
            });

        });
        $("#update").on("click", function(e) {
            e.preventDefault(); // prevent the default form submission

            var data = CKEDITOR.instances.content.getData(); // get the content from CKEditor

            $.ajax({
                url: 'updateData.php',
                type: 'POST',
                data: {
                    'update': 1,
                    'data': data,
                },
                success: function(response) {
                    Swal.fire("Your post is Updated");
                    $("#output").html(response); // Update the HTML content of #output
                    console.log(response); // log the response to the console
                    CKEDITOR.instances.content.setData(''); // Clear the CKEditor textarea
                }
            });
        });
    });
    </script>



</body>

</html>