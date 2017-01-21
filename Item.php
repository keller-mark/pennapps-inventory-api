<?php

class Item extends Model {

	protected $table_name = 'inventory';


	public function buy($quantity) {
		$quantity = intval($quantity);
		$current_quantity = $this->get('quantity');
		if($current_quantity >= $quantity) {
			$this->set('quantity', $current_quantity - $quantity);
			return $quantity;
		} else {
			$this->set('quantity', 0);
			return $current_quantity;
		}
	}

	public function restock($quantity) {
		$quantity = intval($quantity);
		$current_quantity = $this->get('quantity');
		if($quantity >= 0) {
			$this->set('quantity', $current_quantity + $quantity);
		}
	}



}
