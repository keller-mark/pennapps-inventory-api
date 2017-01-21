<?php

class DB {


	protected static $host 	   = 'pennapps-inventory2.chxmmcudxgj7.us-west-2.rds.amazonaws.com';
	protected static $username = 'pennapps_dbuser';

	protected static $database = 'pennappsmysql';


	protected static $tables = array();

	public static function connection() {
		$password = "";
		if(isset($_ENV["RDS_PASSWORD"])) {
			$password = $_ENV["RDS_PASSWORD"];
		}elseif(isset($_SERVER["RDS_PASSWORD"])) {
			$password = $_SERVER["RDS_PASSWORD"];
		}
		return $dbCon = mysqli_connect(self::$host, self::$username, $password, self::$database);
	}

	public static function sql($sql) {
		return mysqli_query(self::connection(), $sql);
	}

	public static function arr($sql) {
		return mysqli_fetch_array( self::sql($sql) );
	}

	public static function getOption($name) {
		$query = self::sql("SELECT value FROM options WHERE name = '" . $name . "' LIMIT 1");
		$row = mysqli_fetch_row($query);
		return $row[0];
	}
	public static function setOption($name, $value) {
		$query = self::sql("UPDATE options SET value = '" . DB::escape($value) . "' WHERE name = '" . DB::escape($name) . "' LIMIT 1");
	}

	public static function getColumns($tableName) {
		if(array_key_exists($tableName, self::$tables)) {
			return self::$tables[$tableName];
		} else {
			$query = self::sql("SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . self::$database . "' AND TABLE_NAME = '" . $tableName . "';");
			$result = array();
			while($row = mysqli_fetch_array($query)) {
				$result[] = $row;
			}
			//echo var_dump($result);
			self::$tables[$tableName] = $result;
			return $result;
		}
	}

	public static function getColumnsHuman($tableName) {
		$columns = self::getColumns($tableName);
		$result = array();
		foreach($columns as $column) {
			if($column["COLUMN_NAME"] != 'id') {
				if(self::endsWith($column["COLUMN_NAME"], '_id')) {
					$result[] = str_replace('_id', '', $column["COLUMN_NAME"]);
				} else {
					$result[] = $column["COLUMN_NAME"];
				}
			}
		}

		return $result;
	}





	public static function sanitize($input) {
		if (is_array($input)) {
			foreach($input as $var=>$val) {
				$output[$var] = sanitize($val);
			}
		}
		else {
			$output = mysqli_real_escape_string(self::connection(), strip_tags($input));
		}
		return $output;
	}
	public static function escape($input) {
		if (is_array($input)) {
			foreach($input as $var=>$val) {
				$output[$var] = escape($val);
			}
		}
		else {
			$output = mysqli_real_escape_string(self::connection(), $input);
		}
		return $output;
	}


}
