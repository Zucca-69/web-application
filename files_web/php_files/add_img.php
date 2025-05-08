<?php
    include 'db_connection.php';

    // Check if $_FILES count items
    if (count($_FILES) > 0) {
        // Check if file was uploaded
        if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
            // Insert image as MySQL BLOB using file_get_contents() to read the entire file into a string
            $imgData = file_get_contents($_FILES['userImage']['tmp_name']);
            $imgName = $_FILES['userImage']['name'];
            $imgType = $_FILES['userImage']['type'];
            $imgSize = $_FILES['userImage']['size'];
            $FKproductId = $_POST['FKproductId'];

            $sql = "INSERT INTO immagini(imageData, imageName, imageType, imageSize, FKproductId) VALUES(?, ?, ?, ?, ?)";
            $statement = $conn->prepare($sql);
            $statement->bind_param('ssssi', $imgData, $imgName, $imgType, $imgSize, $FKproductId);

            $current_id = $statement->execute() or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_connect_error());
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

    }

?>

<HTML>
    <HEAD>
        <TITLE>PHP | Upload BLOB files in MySQL</TITLE>
        <meta charset="UTF-8">
    </HEAD>

    <BODY>
        <!--- Upload the image file --->
        <form name="frmImage" enctype="multipart/form-data" action="" method="post">
            <div>
                <div>
                    <label>Upload image file:</label>
                    <input name="userImage" type="file"/>
                </div>
                
                <div>
                    <label>productId</label>
                    <input name="FKproductId" type= "number"/>
                </div>
                
                <div>
                    <input type="submit" value="Submit" />
                </div>
            </div>
    </BODY>
</HTML>