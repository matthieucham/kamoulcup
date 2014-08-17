<?php
include("dbConfig.php");

Class db extends dbConfig
{
	var $connection;

	function db()
	{
		$this->connect();
	}

	function connect()
	{
		$this->connection=mysql_connect($this->config['db_server'],$this->config['db_username'],$this->config['db_password']);
		if($this->connection) {
			mysql_set_charset('utf8',$this->connection);
			@mysql_select_db($this->config['db_name'],$this->connection);
		}
	}

	function updateTable($table, $field, $value, $id)
	{
		return mysql_query("update {$table} set {$field} = '{$value}' where id = {$id}", $this->connection);
	}

	function deleteFromTable($table, $id)
	{
		return mysql_query("delete from {$table} where id = {$id} limit 1", $this->connection);
	}

	function getArray($query)
	{
		if($result = @mysql_query($query, $this->connection))
		{
			while($tmp = @mysql_fetch_array($result)) {
				$dbarray[]= $tmp;
			}
			if (isset($dbarray))
			return $dbarray;
			else return NULL;
		}
		return;
	}

	function query($query)
	{
		return mysql_query($query, $this->connection);
	}
};

$db = new db;
?>