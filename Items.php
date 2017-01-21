<?php

class Items {

	protected static $table_name = 'inventory';

	public static function findAll() {
		$query = DB::sql("SELECT * FROM " . self::$table_name . " ORDER BY id DESC");
		$result = array();
		while($row = mysqli_fetch_array($query)) {
			$result[] = self::find($row['id']);
		}
		return $result;
	}


	public static function find($id) {
		return new Item(DB::sanitize($id));
	}
	public static function delete($id) {
		$query = DB::sql("DELETE FROM " . self::$table_name . " WHERE id = " . DB::sanitize($id) . "");
	}


}
