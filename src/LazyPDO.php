<?php

namespace LazyPDO;

use PDO;


class LazyPDO extends PDO {

	/**
	 * @var string
	 */
	protected $dsn;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var array
	 */
	protected $options = [];

	/**
	 * @var boolean True if PDO was initialized
	 */
	protected $initialized = false;

	/**
	 * Creates a lazy-loaded PDO instance representing a connection to a database
	 *
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array $options
	 * @return PDO
	 */
	public function __construct($dsn, $username = null, $password = null, array $options = [])
	{
		$this->dsn = $dsn;
		$this->username = $username;
		$this->password = $password;
		$this->options = $options;
	}

	/**
	 * Init PDO once, if not already initialized
	 *
	 */
	protected function initialize()
	{
		if (!$this->initialized) {
			parent::__construct($this->dsn, $this->username, $this->password, $this->options);
			$this->initialized = true;
		}
	}

	### Overloaded PDO methods

	/**
	 * Initiates a transaction
	 *
	 * @return boolean
	 */
	public function beginTransaction()
	{
		$this->initialize();
		return parent::beginTransaction();
	}

	/**
	 * Commits a transaction
	 *
	 * @return boolean
	 */
	public function commit()
	{
		$this->initialize();
		return parent::commit();
	}

	/**
	 * Fetch the SQLSTATE associated with the last operation on the database handle
	 *
	 * @return mixed
	 */
	public function errorCode()
	{
		$this->initialize();
		return parent::errorCode();
	}

	/**
	 * Fetch extended error information associated with the last operation on the database handle
	 *
	 * @return array
	 */
	public function errorInfo()
	{
		$this->initialize();
		return parent::errorInfo();
	}

	/**
	 * Execute an SQL statement and return the number of affected rows
	 *
	 * @param string $statement
	 * @return int
	 */
	public function exec($statement)
	{
		$this->initialize();
		return parent::exec($statement);
	}

	// not needed - doesnt require db conenction
	// public function getAttribute($attribute)
	// {
	// }

	// not needed - static function
	// public static function getAvailableDrivers()
	// {
	// }

	/**
	 * Checks if inside a transaction
	 *
	 * @return boolean
	 */
	public function inTransaction()
	{
		$this->initialize();
		return parent::inTransaction();
	}

	/**
	 * Returns the ID of the last inserted row or sequence value
	 *
	 * @param string $name
	 * @return string
	 */
	public function lastInsertId($name = null)
	{
		$this->initialize();
		return parent::lastInsertId($name);
	}

	/**
	 * Prepares a statement for execution and returns a statement object
	 *
	 * @param string $statement
	 * @param array $driver_options
	 * @return \PDOStatement
	 */
	public function prepare($statement, array $driver_options = [])
	{
		$this->initialize();
		return parent::prepare($statement, $driver_options);
	}

	/**
	 * Executes an SQL statement, returning a result set as a PDOStatement object
	 *
	 * @param string $statement
	 * @return \PDOStatement
	 */
	public function query($statement)
	{
		$this->initialize();
		return call_user_func_array('parent::query', func_get_args());
	}

	/**
	 * Rolls back a transaction
	 *
	 * @return boolean
	 */
	public function rollback()
	{
		$this->initialize();
		return parent::rollBack();
	}

	// not needed - doesnt require database connection
	// public function setAttribute($attribute, $value)
	// {
	// }

}
