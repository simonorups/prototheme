<?php
include 'check-session.php';
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $place = isset($_POST['place']) ? $_POST['place'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $continent = isset($_POST['continent']) ? $_POST['continent'] : '';
    $cost = isset($_POST['cost']) ? $_POST['cost'] : '';
    $days = isset($_POST['days']) ? $_POST['days'] : '';
    $distance = isset($_POST['distance']) ? $_POST['distance'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';

    /**To be moved to a function**/
    $target_dir = "uploads/destinations/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    echo $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_FILES["image"]["name"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "webp"
    ) {
        echo "Sorry, only JPG, JPEG, PNG, WEBP & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
        } else {
            // echo "Sorry, there was an error uploading your file.";
        }
    }
    // Insert new record into the travel_destinations table

    $stmt = $pdo->prepare('INSERT INTO travel_destinations(place, description, continent, image_path, cost, travel_days, distance, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $result = $stmt->execute([$place, $description, $continent, $target_file, $cost, $days, $distance, $status]);
    // Output message
    if ($result) {
        $msg = 'Destination Created Successfully!';
        $txtColor = 'success';
    } else {
        // var_dump($stmt->errorInfo()[2]);
        $msg = 'Destination Not Created! with error >> ' . $stmt->errorInfo()[2];
        $txtColor = 'danger';
    }
}

?>

<?= template_header('Create') ?>

<div class="content update">
    <h2>Create Destination</h2>
    <?php if ($msg): ?>
        <p class="bg-<?= $txtColor ?>">
            <?= $msg ?>
        </p>
    <?php endif; ?>
    <form action="create.php" method="post" enctype="multipart/form-data">
        <label for="place">Place</label>
        <label for="image">Image</label>
        
        <input type="text" name="place" placeholder="Hong Kong" id="place" required>
        <input type="file" name="image" id="image" accept="image/*" required>
                
        <label for="name">Description</label>
        <label for="image">Continent</label>
        <textarea rows="2" cols="40" class="" name="description" placeholder="Some place in china..." required></textarea>
        <select name="continent" required id="continent">
            <option value="">--Select-</option>
            <option value="Asia">Asia</option>
            <option value="Africa">Africa</option>
            <option value="Europa">Europa</option>
            <option value="America">America</option>
        </select>
        <!-- <input type="text" name="description" placeholder="Some place in china" id="name" required> -->

        <label for="cost">Cost</label>
        <label for="days">Travel Days</label>
        <input type="text" name="cost" placeholder="10000" id="cost" required>
        <input type="text" name="days" placeholder="Approx 2 night trip" id="days" required>
        <label for="distance">Distance</label>
        <label for="status">Status</label>
        <input type="text" name="distance" placeholder="1000 Kms" id="distance" required>
        <select name="status" required id="status">
            <option value="1">Active</option>
            <option value="0">In Active</option>
        </select>
        <div class="w-100">
            <input type="submit" name="create" value="Create">
        </div>
    </form>
</div>

<?= template_footer() ?>