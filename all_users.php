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
	
	$stmt = $pdo->query('SELECT users.id as users_id, username, email, name FROM users JOIN status ON users.status_id = status.id ORDER BY username');

?>
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