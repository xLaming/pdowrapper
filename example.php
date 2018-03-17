<?php
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', 'mypassword');
define('MYSQL_DB', 'testdb');

require_once('PDO.php');

$sql = new PDOWrapper(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

/* Delete ID 1 from users */
$sql->query("DELETE FROM users WHERE id = 1")

/* Select ID from users if user is admin */
$sql->fetch_array("SELECT id FROM users WHERE user = 'admin'");

/* Insert data database */
$sql->insert('test', ['id' => 10, 'name' => 'Paulo', 'age' => '18'])

/* Search my name Paulo in the table test */
$sql->search('test', ['name', 'Paulo'])

/* Count total of rows in table */
$sql->rowCount("users")

/* Count total of tables in the database */
$sql->tablesCount()

/* Get last inserted id */
$sql->lastInsertId()
?>
