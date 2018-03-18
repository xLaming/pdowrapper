# PDO Wrapper
* This is a free PDO class written in PHP that you use to handle connections to databases like MySQL, SQLite etc.

### Connection method:
$sql = new PDOWrapper('localhost', 'root', 'mypassword', 'test_database');

### Using query's method:
* Using to delete queries:
    * $sql->query("DELETE FROM users WHERE id = 1")
    
* Using to update queries:
    * $sql->query("UPDATE users SET password = 'abc123' WHERE id = 1")

### Fetch data on database:
* Selecting a ID from a table:
    * $sql->fetch_array("SELECT id FROM users WHERE user = 'admin'");
    
* Showing all values from a table:
    * $sql->fetch_array("SELECT id FROM users");

### Insert data to database:
$sql->insert('users', ['id' => 10, 'name' => 'Paulo', 'age' => '18'])

### Update data on the database:
$sql->update('test', ['age' => '18', 'name' => 'Paulo'], ['id' => 10])
* First array are the values to be updated.
* Second array is/are the parameter used in WHERE. E.g: *id => 10* will be *WHERE id = 10*.

### Search data on database:
$sql->search('users', ['name', 'Paulo'])
* First field in the array is the column name.
* Second field in the array is the value.

### Count rows in one table:
$sql->rowCount("users")

### Count tables in the database:
$sql->tablesCount()

### Get the last inserted id:
$sql->lastInsertId()
