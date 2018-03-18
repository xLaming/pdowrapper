<?php
/**
 * *** PDO WRAPPER ***
 * This class is used to connect to PDO(Wrapper method). It will make the connection easier.
 * @copyright MIT License. Copyright (c) 2018 Paulo Rodriguez
 * @author Paulo Rodriguez(xLaming)
 * @link https://github.com/xlaming/pdowrapper
 * @version 1.1 (stable)
 */
class PDOWrapper
{
	/**
	 * Set-up the driver used to connect to database and also the charset.
	 * @var array
	 */
	private $settings = [
		'driver'  => 'mysql', // driver method
		'charset' => 'utf8' // charset type
	];

	/**
	 * Set-up some attributes that will be used in the connection method.
	 * @var array
	 */
	private $options  = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];

	/**
	 * Store the connection to use in other functions.
	 * @var string
	 */
	private $link;

	/**
	 * Store the result to use in other functions.
	 * @var string
	 */
	private $result;

	/**
	 * This will connect to the database.
	 * @param string $host
	 * @param string $user
	 * @param string $pass
	 * @param string $dbname
	 * @return string
	 */
	public function __construct($host, $user, $pass, $dbname)
	{
		try
		{
			$setDriver  = "{$this->settings['driver']}:host={$host};dbname={$dbname};charset={$this->settings['charset']}";
			$this->link = new PDO($setDriver, $user, $pass, $this->options);
		}
		catch (PDOException $e)
		{
			 echo $e->getMessage();
			 exit;
		}
	}

	/**
	 * Execute query directly on the driver.
	 * Example: $sql->query('DELETE FROM users WHERE id = 1')
	 * @param  string $string
	 * @return mixed
	 */
	public function query($string)
	{
		if (!is_string($string))
		{
			return false;
		}
		$this->result = $this->link->query($string);
		return $this->result;
	}

	/**
	 * Fetch data in the database using the connection driver.
	 * Example: $sql->fetch_array("SELECT id FROM users WHERE user = 'admin'");
	 * @param  string $string
	 * @return mixed
	 */
	public function fetch_array($string)
	{
		if (!is_string($string))
		{
			return false;
		}
		$this->query($string);
		$result = $this->result->fetchAll();
		return $result;
	}

	/**
	 * Insert data to the database using the connection driver.
	 * Example: $sql->insert('test', ['id' => 10, 'name' => 'Paulo', 'age' => '18'])
	 * @param  string $table
	 * @param  array $values
	 * @return mixed
	 */
	public function insert($table, $values)
	{
		if (!is_string($table) || !is_array($values))
		{
			return false;
		}
		$keys    = implode(", ", array_keys($values));
		$addAsks = substr(str_repeat("?, ", count($values)), 0, -2);
		$prepare = $this->link->prepare("INSERT INTO {$table} ({$keys}) VALUES ({$addAsks})");
		$prepare->execute(array_values($values));
		return $prepare;
	}

	/**
	 * Update data on the database.
	 * * Example: $sql->update('test', ['age' => '18'], ['id' => 10])
	 * @param  string $table
	 * @param  array $values
	 * @param  array $where
	 * @return mixed
	 */
	public function update($table, $values, $where)
	{
		if (!is_string($table) || !is_array($values) || !is_array($where))
		{
			return false;
		}
		list($keysC, $whereC) = [null, null];
		foreach ($values as $k => $v)
		{
			$keysC .= "{$k} = ?, ";
		}
		foreach ($where as $k => $v)
		{
			$whereC .= "{$k} = '{$v}' AND "; // may be changed later eww...
		}
		list($keys, $where, $values) = [
			substr($keysC, 0, -2),
			substr($whereC, 0, -5)
			array_values($values),
		];
		$prepare  = $this->link->prepare("UPDATE {$table} SET {$keys} WHERE {$where}");
		$prepare->execute(array_values($values));
		return $prepare;
	}

	/**
	 * Search data in the database using the connection driver.
	 * Example: $sql->search('test', ['name', 'Paulo'])
	 * @param  string $table
	 * @param  array $values
	 * @return mixed
	 */
	public function search($table, $values)
	{
		if (!is_string($table) || !is_array($values) || count($values) < 2)
		{
			return false;
		}
		$result = $this->fetch_array("SELECT * FROM {$table} WHERE {$values[0]} LIKE '%{$values[1]}%'");
		if (empty($result))
		{
			return false;
		}
		return $result;
	}

	/**
	 * Count all rows existant in one table.
	 * Example: $sql->rowCount("users")
	 * @param  string $table
	 * @return mixed
	 */
	public function rowCount($table)
	{
		if (!is_string($table))
		{
			return false;
		}
		$result = $this->fetch_array("SELECT * FROM {$table}");
		return count($result);
	}

	/**
	 * Count all tables existant in one database. (may be useful for debugs)
	 * @return int
	 */
	public function tablesCount()
	{
		$result = $this->fetch_array("SHOW TABLES");
		return count($result);
	}

	/**
	 * Search the last inserted value.
	 * @return int
	 */
	public function lastInsertId()
	{
		return $this->link->lastInsertId();
	}
}
?>
