<?php
	class Product
	{
		public $name;
		public $price;
			
		public function __construct($name, $price) {	// main constructor
			$this->name = $name;
			$this->price = $price;
		}
		public function sum($value){	// this method sums price for products w/o volume
			if($value != 0)
			return array_sum(array_column($value, 'price'));
		}
	}
?>