<?php
/**
* Database abstract
*/
class DbAbstract
{
	static $server;
	static $port;
	static $database;
	static $user;
	static $password;
	private static $pdo;

	static function openConnect(){
		try{
			self::$server = DB_SERVER;
			self::$port = DB_PORT;
			self::$database = DB_DATABASE;
			self::$user = DB_USER;
			self::$password = DB_PASSWORD;
			self::$pdo = self::connection();
			return self::$pdo;
		}catch(Exception $e){
			die('Erro na conexão com o banco de dados.');
		}
	}

	static function connection(){
		$connection = sprintf("mysql:host=%s;port=%s;dbname=%s", self::$server, self::$port, self::$database);
		self::$pdo = new PDO($connection, self::$user, self::$password);
		self::$pdo->exec('set names utf8');
		return self::$pdo;
	}

}