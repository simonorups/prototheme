<?php
include 'check-session.php';
include 'functions.php';
?>

<?= template_header('Home') ?>

<div class="content">
	<h2>Destinations</h2>
	<p>Below are a list of available travel destinations!</p>

	<?php
	// Connect to MySQL database
	$pdo = pdo_connect_mysql();
	// Get the page via GET request (URL param: page), if non exists default the page to 1
	$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
	// Number of records to show on each page
	$records_per_page = 5;

	// Prepare the SQL statement and get records from our travel_destinations table, LIMIT will determine the page
	$stmt = $pdo->prepare('SELECT * FROM travel_destinations ORDER BY id LIMIT :current_page, :record_per_page');
	$stmt->bindValue(':current_page', ($page - 1) * $records_per_page, PDO::PARAM_INT);
	$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
	$stmt->execute();
	// Fetch the records so we can display them in our template.
	$travel_destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// Get the total number of travel_destinations, this is so we can determine whether there should be a next and previous button
	$num_travel_destinations = $pdo->query('SELECT COUNT(*) FROM travel_destinations')->fetchColumn();
	?>

	<div class="read">
		<a href="create.php" class="create-contact">Create Destination</a>
		<table>
			<thead>
				<tr>
					<td>#</td>
					<td>Place</td>
					<td>Image</td>
					<td width="20%">Description</td>
					<td>Cost</td>
					<td>Travel Duration</td>
					<td>Distance</td>
					<td>Created</td>
					<td>Status</td>
					<td>Actions</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($travel_destinations as $contact): ?>
					<tr>
						<td>
							<?= $contact['id'] ?>
						</td>
						<td>
							<?= $contact['place'] ?>
						</td>
						<td>
							<img src="<?= $contact['image_path'] ?>" height="50" />
						</td>
						<td>
							<?= $contact['description'] ?>
						</td>
						<td>
							<?= $contact['cost'] ?>
						</td>
						<td>
							<?= $contact['travel_days'] ?>
						</td>
						<td>
							<?= $contact['distance'] ?>
						</td>
						<td>
							<?= $contact['created_at'] ?>
						</td>
						<td>
							<?= $contact['status'] ?>
						</td>
						<td class="actions">
							<a href="update.php?id=<?= $contact['id'] ?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
							<a href="delete.php?id=<?= $contact['id'] ?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="pagination">
			<?php if ($page > 1): ?>
				<a href="index.php?page=<?= $page - 1 ?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
			<?php endif; ?>
			<?php if ($page * $records_per_page < $num_travel_destinations): ?>
				<a href="index.php?page=<?= $page + 1 ?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
			<?php endif; ?>
		</div>
	</div>

</div>

<?= template_footer() ?>