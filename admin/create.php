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
    $cost = isset($_POST['cost']) ? $_POST['cost'] : '';
    $days = isset($_POST['days']) ? $_POST['days'] : '';
    $distance = isset($_POST['distance']) ? $_POST['distance'] : '';
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    // Insert new record into the travel_destinations table
    
    $stmt = $pdo->prepare('INSERT INTO travel_destinations(place, description, cost, travel_days, distance, status) VALUES (?, ?, ?, ?, ?, ?)');
    $result = $stmt->execute([$place, $description, $cost, $days, $distance, $status]);
    // Output message
    if ($result) {
        $msg = 'Destination Created Successfully!';
        $txtColor = 'success';
    } else {
        // var_dump($stmt->errorInfo()[2]);
        $msg = 'Destination Not Created! with error >> '.$stmt->errorInfo()[2];
        $txtColor = 'danger';
    }
}

?>

<?= template_header('Create') ?>

<div class="content update">
    <h2>Create Contact</h2>
    <?php if ($msg): ?>
        <p class="bg-<?=$txtColor?>">
            <?= $msg ?>
        </p>
    <?php endif; ?>
    <form action="create.php" method="post">
        <label for="place">Place</label>
        <label for="name">Description</label>
        <input type="text" name="place" placeholder="Hong Kong" id="place" required>
        <input type="text" name="description" placeholder="Some place in china" id="name" required>
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
            <input type="submit" value="Create">
        </div>
    </form>
</div>

<?= template_footer() ?>