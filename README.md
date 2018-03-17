# PDO Wrapper
* This is a free PDO class written in PHP that you use to handle connections to databases like MySQL, SQLite etc.

### Connection method:
$sql = new PDOWrapper('localhost', 'root', 'mypassword', 'test_database');

### Using query's method:
#### Examples:
* Using to delete queries:
    * $sql->query("DELETE FROM users WHERE id = 1")
    
* Using to update queries:
    * $sql->query("UPDATE users SET password = 'abc123' WHERE id = 1")

### Fetch data on database:
#### Examples:
* Selecting a ID from a table:
    * $sql->fetch_array("SELECT id FROM users WHERE user = 'admin'");
    
* Showing all values from a table:
    * $sql->fetch_array("SELECT id FROM users");

### Insert data to database:
#### Example:
$sql->insert('users', ['id' => 10, 'name' => 'Paulo', 'age' => '18'])

### Search data on database:
#### Example:
$sql->search('users', ['name', 'Paulo'])

### Count rows in one table
#### Example:
$sql->rowCount("users")

### Count tables in the database:
#### Example:
$sql->tablesCount()

### Get the last inserted id:
#### Example:
$sql->lastInsertId()
