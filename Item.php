<?php

class Item extends Model {

	protected $table_name = 'inventory';

 
	public function buy($quantity, $customer_id) {
		$quantity = intval($quantity);
		$current_quantity = $this->get('quantity');
		if($current_quantity >= $quantity) {
			$this->set('quantity', $current_quantity - $quantity);
			$this->customerTransaction($quantity, $customer_id);
			return $quantity;
		} else {
			$this->set('quantity', 0);
			$this->customerTransaction($current_quantity, $customer_id);
			return $current_quantity;
		}
	}

	private function customerTransaction($quantity, $customer_id) {

		$transaction_total = $quantity * $this->get('item_price');
		if($transaction_total > 1.00) {
			$capitalOneData = array(
				"medium" => "balance",
				"payee_id" => "588300231756fc834d8eb6ad",
				"amount" => floatval(dollar_format($transaction_total)),
				"transaction_date" => date("Y-m-d"),
				"description" => "" . $quantity . " " . Inflector::pluralize($this->get('item_name'))
			);

			$capitalOneDataString = json_encode($capitalOneData);
			//print_r($capitalOneDataString);


			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,"http://api.reimaginebanking.com/accounts/" . $customer_id . "/transfers?key=b1ce1c6f1d2ff56d0ac730b6136b623b");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $capitalOneDataString);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($capitalOneDataString))
			);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$server_output = curl_exec ($ch);

			curl_close ($ch);

			//print_r($server_output);
		}
	}



	public function restock($quantity) {
		$quantity = intval($quantity);
		$current_quantity = $this->get('quantity');
		if($quantity >= 0) {
			$this->purchaseItems($quantity);
			$this->set('quantity', $current_quantity + $quantity);
		}
	}

	private function purchaseItems($quantity) {

		$capitalOneData = array(
			"merchant_id" => "5882e3e91756fc834d8eb684",
			"medium" => "balance",
			"purchase_date" => date("Y-m-d"),
			"amount" => ($quantity * $this->get('item_price')),
			"description" => "" . $quantity . " " . Inflector::pluralize($this->get('item_name'))
		);

		$capitalOneDataString = json_encode($capitalOneData);


		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,"http://api.reimaginebanking.com/accounts/588300231756fc834d8eb6ad/purchases?key=b1ce1c6f1d2ff56d0ac730b6136b623b");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $capitalOneDataString);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($capitalOneDataString))
		);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec ($ch);

		curl_close ($ch);

	}



}
