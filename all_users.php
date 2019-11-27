<?php
	$host='localhost';
	$db='my_activities';
	$user='root';
	$pass='root';
	$charset='utf8';
	$dsn="mysql:host=$host;dbname=$db;charset=$charset";
	$options = [
	PDO::ATTR_ERRMODE            =>PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES   =>false,
	];
	try {
		$pdo = new PDO($dsn,$user,$pass,$options);
	} catch(PDOException $e) {
		throw new PDOException($e->getMessage(), (int)$e->getCode());
	}
	
	$start_letter = 'e';
	$status_id = 1;
	
	$frm = $pdo->query("SELECT * FROM status");
	
	?>
	

<?php
	function get($name) {
		return isset($_GET[$name]) ? $_GET[$name] : null;
	}
	$start_letter = htmlspecialchars(get("start_letter"));
	$status_id = (int)get("status_id");

	if (isset($_GET['status'])){
		$status_id = $_GET['status'];
	}
	
	$stmt = $pdo->query("SELECT users.id as users_id, username, email, name
						 FROM users
						 JOIN status
						 ON users.status_id = status.id
						 WHERE status.id = $status_id
						 AND username LIKE '$start_letter%'
						 ORDER BY username");

?>
<form action="all_users.php" method="get">
	Start with letter: <input name="start_letter" type="text" value="<?php echo get("start_letter") ?>">
	and status is: <select name="status_id">
			<option value="1" <?php if (get("status_id") == 1) echo 'selected' ?>>Waiting for account validation</option>
			<option value="2" <?php if (get("status_id") == 2) echo 'selected' ?>>Active account</option>
		</select>
	<input type="submit" value="OK">
</form>

<table>
	<tr>
		<th>Id</th>
		<th>Username</th>
		<th>Email</th>
		<th>Status</th>
	</tr>
	<tr>
		<?php
			while ($row = $stmt->fetch()) {
				echo "<tr>";
				echo "<td>$row[users_id]</td>";
				echo "<td>$row[username]</td>";
				echo "<td>$row[email]</td>";
				echo "<td>$row[name]</td>";
				echo "</tr>";
			}
		?>
</table>