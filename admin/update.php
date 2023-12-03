<?php
include 'check-session.php';
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the destination id exists, for example update.php?id=1 will get the destination with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $place = isset($_POST['place']) ? $_POST['place'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $cost = isset($_POST['cost']) ? $_POST['cost'] : '';
        $days = isset($_POST['days']) ? $_POST['days'] : '';
        $distance = isset($_POST['distance']) ? $_POST['distance'] : '';
        $status = isset($_POST['status']) ? $_POST['status'] : '';

        /**To be moved to a function**/
        $target_dir = "uploads/destinations/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
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

        $imageUpdated = 0;
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";
                $imageUpdated = 1;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $updateSql = "UPDATE travel_destinations SET place = ?, description = ?, cost = ?, travel_days = ?, distance = ?, status = ? WHERE id = ?";
        $updateData = [$place, $description, $cost, $days, $distance, $status, $_GET['id']];

        if ($imageUpdated > 0) {
            $updateSql = "UPDATE travel_destinations SET place = ?, description = ?, image_path = ?, cost = ?, travel_days = ?, distance = ?, status = ? WHERE id = ?";
            $updateData = [$place, $description, $target_file, $cost, $days, $distance, $status, $_GET['id']];
        }

        // Update the record
        $stmt = $pdo->prepare($updateSql);
        $result = $stmt->execute($updateData);
        $msg = 'Updated Successfully!';

        // Output message
        if ($result) {
            $msg = 'Destination Updated Successfully!';
            $txtColor = 'success';
        } else {
            // var_dump($stmt->errorInfo()[2]);
            $msg = 'Destination Not Updated! with error >> ' . $stmt->errorInfo()[2];
            $txtColor = 'danger';
        }
    }
    // Get the destination from the travel_destinations table
    $stmt = $pdo->prepare('SELECT * FROM travel_destinations WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $destination = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$destination) {
        exit('Destination doesn\'t exist with that ID!');
    }

} else {
    exit('No ID specified!');
}
?>

<?= template_header('Read') ?>

<div class="content update">
    <h2>Update destination #
        <?= $destination['id'] ?>
    </h2>
    <?php if ($msg): ?>
        <p class="bg-<?= $txtColor ?>">
            <?= $msg ?>
        </p>
    <?php endif; ?>

    <form action="update.php?id=<?= $destination['id'] ?>" method="post" enctype="multipart/form-data">
        <label for="place">Place</label>
        <label for="image">Image</label>
        
        <input type="text" name="place" placeholder="Hong Kong" id="place" value="<?= $destination['place'] ?>"
            required>
        <input type="file" name="image" id="image" accept="image/*, .webp" required>

        <label for="name">Description</label>
        <textarea rows="2" cols="40" class="entirerow" name="description" required><?= $destination['description'] ?></textarea>

        
        
        
        <label for="cost">Cost</label>
        <label for="days">Travel Days</label>
        <input type="text" name="cost" placeholder="10000" value="<?= $destination['cost'] ?>" id="cost" required>
        <input type="text" name="days" placeholder="Approx 2 night trip" value="<?= $destination['travel_days'] ?>"
            id="days" required>
        <label for="distance">Distance</label>
        <label for="status">Status</label>
        <input type="text" name="distance" placeholder="1000 Kms" value="<?= $destination['distance'] ?>" id="distance"
            required>
        <select name="status" required id="status">
            <option value="1" <?= ($destination['status'] == 1) ? "selected" : "" ?>>Active</option>
            <option value="0" <?= ($destination['status'] == 0) ? "selected" : "" ?>>In Active</option>
        </select>
        <div class="w-100">
            <input type="submit" value="Update">
        </div>
    </form>
</div>

<?= template_footer() ?>