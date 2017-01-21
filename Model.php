<?php

class Model extends CMS {

	protected $table_name = 'table_name';

	protected $id 			= '';
	protected $vars = array();

	protected $active;

	public function __construct() {
		global $accountType;
		$num_args = func_num_args();

		if($num_args == 1) {
			//id was passed as parameter
			$id = func_get_arg(0);
			$this->id = $id;
			$this->update();

			$this->active = true;
		} else {
			//id was NOT passed, assume it is new object

			$this->active = false;
		}
	}

	public function update() {
		$row = DB::arr("SELECT * FROM " . $this->table_name . " WHERE id = " . $this->id . " LIMIT 1");

		$columns = DB::getColumns($this->table_name);
		foreach($columns as $column) {
			if($column["COLUMN_NAME"] != 'id') {
				$this->vars[ $column["COLUMN_NAME"] ] = $row[ $column["COLUMN_NAME"] ];

			}
		}
	}


	public function set($key, $val) {
		$custom_method = 'set' . ucfirst($key);

		if(method_exists($this, $custom_method)) {
			$this->{$custom_method}($val);
		} else {
			$this->vars[$key] = $val;
		}
	}

	public function get($key) {
    $singleModel = ucfirst($key);
		$custom_method = 'get' . $singleModel;
		//echo $custom_method;
		//debug_print_backtrace();

		if(method_exists($this, $custom_method)) {
			return $this->{$custom_method}();
		} else {
      $possibleObjectIdKey = $key . '_id';

      if(array_key_exists($possibleObjectIdKey, $this->vars)) {

        if(self::startsWith($key, 'image') || self::startsWith($key, 'document')) {
          $singleModel = preg_replace('/[0-9]+/', '', $singleModel);
        }

        $pluralModel = Inflector::pluralize($singleModel);

        if(class_exists($singleModel) && class_exists($pluralModel)) {
          $modelObject = new $pluralModel();
          $object = $modelObject::find( $this->vars[$possibleObjectIdKey] );

          if(!empty($object->get('id'))) {
            return $object;
          }
        }
      }

			return $this->vars[$key];

		}
	}

  public function getString($key) {
    $singleModel = ucfirst($key);
		$custom_method = 'getString' . $singleModel;

		if(method_exists($this, $custom_method)) {
			return $this->{$custom_method}();
		} else {
      $possibleObjectIdKey = $key . '_id';

      if(array_key_exists($possibleObjectIdKey, $this->vars)) {

        if(self::startsWith($key, 'image') || self::startsWith($key, 'document')) {
          $singleModel = preg_replace('/[0-9]+/', '', $singleModel);
        }

        $pluralModel = Inflector::pluralize($singleModel);

        if(class_exists($singleModel) && class_exists($pluralModel)) {
          $modelObject = new $pluralModel();
          $object = $modelObject::find( $this->vars[$possibleObjectIdKey] );

          if(!empty($object->get('id'))) {
            return $object->toString();
          }
        }
      }

			return $this->vars[$key];
		}
	}

  public function toString() {
    return static::class . $this->id;
  }





	//GETTERS

	public function getId() {
		return $this->id;
	}

	//END GETTERS



	public function save() {

		if($this->isActive()) {

			$temp = "";
			foreach($this->vars as $key => $val) {
				$temp .= $key . " = '" . DB::escape($val) . "', ";
			}
			$temp = substr($temp, 0, -2);

			$query = DB::sql("UPDATE " . $this->table_name . " SET " . $temp . " WHERE id = '" . DB::escape($this->id) . "'");

		} else {


			$temp1 = "";
			$temp2 = "";
			$temp3 = "";
			foreach($this->vars as $key => $val) {
				$temp1 .= $key . ", ";
				$temp2 .= "'" . DB::escape($val) . "', ";
				$temp3 .= $key . " = '" . DB::escape($val) . "' AND ";
			}
			$temp1 = substr($temp1, 0, -2);
			$temp2 = substr($temp2, 0, -2);
			$temp3 = substr($temp3, 0, -4);

			$query = DB::sql("INSERT INTO " . $this->table_name . " (" . $temp1 . ")
				VALUES (" . $temp2 . ")");


			$this->active = true;

			$this->id = DB::arr("SELECT * FROM " . $this->table_name . " WHERE " . $temp3 . "")['id'];

		}

	}


	public function isActive() {
		return $this->active;
	}


}
