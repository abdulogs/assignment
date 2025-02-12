<?php

class Database
{
	private $con;
	private $hostname;
	private $username;
	private $password;
	private $dbname;

	public function setHostname($value)
	{
		return $this->hostname = $value;
	}
	public function setUsername($value)
	{
		return $this->username = $value;
	}
	public function setPassword($value)
	{
		return $this->password = $value;
	}
	public function setDatabaseName($value)
	{
		return $this->dbname = $value;
	}
	public function connect()
	{
		try {
			$this->con = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->dbname, $this->username, $this->password);
			$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $this->con;
		} catch (PDOException $e) {
			$error = "";
			$error .= "<h3 style='font-size:16px;font-family:arial;margin:2px 0;'>Opps there is a error in your code</h3>";
			$error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Code :</b> {$e->getCode()}</p>";
			$error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Line number :</b> {$e->getLine()}</p>";
			$error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Filename</b> :</b> {$e->getFile()}</p>";
			$error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Message</b> :</b> {$e->getMessage()}</p>";
			$error .= "<p style='font-size:14px;font-family:arial;margin:2px 0;'><b>Trace</b> :</b>" . $e->getTraceAsString() . "</p>";
			$error .= "<hr>";
			echo $error;
		}
	}
}
